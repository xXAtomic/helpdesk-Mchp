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
            // Usamos el modelo 2.0 detectado en la sonda
            $model = 'gemini-2.0-flash'; 
            $response = $this->callGemini($model, $prompt, $contextText);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text) return $text;
            }

            // Manejo de saturación técnica (429 y 5xx)
            if ($response->status() === 429) {
                return "📡 **LÍMITE DE PENSAMIENTO**: He respondido muchas consultas seguidas. Por favor, espera un minuto para que mi núcleo se enfríe y vuelve a preguntarme.";
            }

            if ($response->status() >= 500) {
                return "🛸 **SATURACIÓN**: El núcleo de IA está procesando muchas solicitudes. Intenta de nuevo en unos segundos.";
            }

            return "El núcleo reportó una anomalía (Código: " . $response->status() . ").";

        } catch (\Exception $e) {
            Log::critical("GravityAIService Error: " . $e->getMessage());
            return "ERROR CRÍTICO: " . $e->getMessage() . " (L:" . $e->getLine() . ")";
        }
    }

    /**
     * Registra un ticket evitado.
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
        $fullPrompt = "Eres GravityBot, asistente técnico de MChP.\nCONTEXTO:\n{$contextText}\n\nPREGUNTA:\n{$prompt}";

        return Http::withHeaders(['x-goog-api-key' => $this->apiKey])
            ->timeout(30)
            ->post("{$this->baseUrl}/{$model}:generateContent", [
                'contents' => [
                    ['parts' => [['text' => $fullPrompt]]]
                ]
            ]);
    }

    /**
     * Respuesta de reserva.
     */
    private function fallbackResponse(string $prompt)
    {
        return "GravityBot fuera de línea (Configuración pendiente).";
    }
}
