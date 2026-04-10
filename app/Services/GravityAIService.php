<?php

namespace App\Services;

use App\Models\Knowledge;
use App\Models\TicketDeflection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/**
 * Servicio central de Inteligencia Artificial y Búsqueda Semántica (GravityBot).
 */
class GravityAIService
{
    private $apiKey;
    private $baseUrl = "https://generativelanguage.googleapis.com/v1beta/models";

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    /**
     * Busca contexto relevante en la base de conocimientos (RAG).
     */
    public function getKnowledgeContext(string $query, int $limit = 3)
    {
        if (strlen($query) < 3) return collect();

        return Knowledge::where('is_published', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Genera una respuesta usando el motor de IA de Google Gemini.
     */
    public function askAI(string $prompt, string $contextText = "")
    {
        if (!$this->apiKey) {
            return $this->fallbackResponse($prompt);
        }

        try {
            // Cambiamos a 'latest' o 'pro' para mayor compatibilidad
            $model = 'gemini-1.5-flash-latest'; 
            $response = $this->callGemini($model, $prompt, $contextText);

            // Si el modelo específico falla, intentamos autodetectar uno válido
            if ($response->status() === 404) {
                $model = $this->autoDetectModel() ?: 'gemini-pro';
                $response = $this->callGemini($model, $prompt, $contextText);
            }

            if ($response->successful()) {
                $data = $response->json();
                
                // Validación robusta de la estructura de respuesta
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                if ($text) return $text;

                Log::warning("Gemini structure unexpected: " . json_encode($data));
                return "Gravity Bot ha procesado tu consulta pero la respuesta fue filtrada por seguridad o vino vacía.";
            }

            // Manejo de errores de servidor (503, 500, etc)
            if ($response->status() >= 500) {
                return "🛸 **ESTADO DE SATURACIÓN**: El núcleo de IA está procesando muchas solicitudes en este segundo. Por favor, reintenta tu pregunta en un momento.";
            }

            Log::error("Gemini API Error: " . $response->body());
            return "El núcleo reportó una anomalía (Código: " . $response->status() . ").";

        } catch (\Exception $e) {
            Log::critical("GravityAIService Exception: " . $e->getMessage());
            return "Error crítico en el proceso de pensamiento de Gravity.";
        }
    }

    /**
     * Registra un ticket evitado gracias a la ayuda de la IA o Manuales.
     */
    public function recordDeflection(array $data)
    {
        return TicketDeflection::create([
            'user_id' => Auth::id(),
            'title' => $data['title'] ?? null,
            'article_id' => $data['article_id'] ?? null,
            'method' => $data['method']
        ]);
    }

    /**
     * Helper para la llamada HTTP a Gemini.
     */
    private function callGemini(string $model, string $prompt, string $contextText)
    {
        $systemInstructions = "Eres GravityBot, el asistente de soporte técnico Inteligente de MChP. 
        Personalidad: Técnica, amigable y eficiente.
        INSTRUCCIONES:
        1. Usa el CONTEXTO proporcionado para responder detalladamente.
        2. Si NO está en el contexto, usa tu conocimiento general pero advierte que es una sugerencia general.
        3. Responde siempre en Español.";

        $fullPrompt = "{$systemInstructions}\n\nCONTEXTO:\n{$contextText}\n\nPREGUNTA DEL USUARIO:\n{$prompt}";

        return Http::retry(3, 200) // Reintenta 3 veces con 200ms entre cada intento
            ->withHeaders(['x-goog-api-key' => $this->apiKey])
            ->post("{$this->baseUrl}/{$model}:generateContent", [
                'contents' => [['parts' => [['text' => $fullPrompt]]]]
            ]);
    }

    /**
     * Intenta detectar qué modelos están disponibles para esta API Key.
     */
    private function autoDetectModel(): ?string
    {
        $response = Http::withHeaders(['x-goog-api-key' => $this->apiKey])
            ->get($this->baseUrl);

        if ($response->successful()) {
            $models = $response->json()['models'] ?? [];
            foreach($models as $m) {
                if (in_array('generateContent', $m['supportedGenerationMethods'] ?? [])) {
                    return str_replace('models/', '', $m['name']);
                }
            }
        }
        return null;
    }

    /**
     * Respuesta de reserva si la IA no está disponible.
     */
    private function fallbackResponse(string $prompt)
    {
        $context = $this->getKnowledgeContext($prompt);
        if ($context->count() > 0) {
            $resp = "IA no configurada. Sugerencias de manuales encontrados:\n\n";
            foreach($context as $item) {
                $resp .= "📍 **{$item->title}**: " . substr($item->content, 0, 150) . "...\n";
            }
            return $resp;
        }
        return "GravityBot está fuera de línea (API Key faltante). Por favor, contacta a TI.";
    }
}
