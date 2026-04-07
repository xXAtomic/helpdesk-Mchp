<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Knowledge;

class GravityBotController extends Controller
{
    public function chat(Request $request)
    {
        $prompt = $request->input('prompt');
        
        // 1. Buscar contexto en Knowledge Base (RAG Simple) ✨
        // Intentamos encontrar manuales que coincidan con la duda del usuario
        $context = Knowledge::where('is_published', true)
            ->where(function ($q) use ($prompt) {
                // Buscamos por palabras clave básicas
                $q->where('title', 'like', "%{$prompt}%")
                  ->orWhere('content', 'like', "%{$prompt}%");
            })
            ->limit(3)
            ->get();

        $contextText = "";
        foreach($context as $item) {
            $contextText .= "MANUAL: {$item->title}\nPROCEDIMIENTO: {$item->content}\n---\n";
        }

        // 2. Llamada a Gemini API 🧠
        $apiKey = config('services.gemini.key');
        
        // Si no hay API KEY, respondemos con el contexto encontrado (Fallback)
        if (!$apiKey) {
            $fallback = "¡Hola! Soy GravityBot. Actualmente mi núcleo de IA (Gemini) no está configurado en el archivo .env.\n\n";
            if ($context->count() > 0) {
                $fallback .= "Sin embargo, he buscado en los manuales y encontré esta información que puede servirte:\n\n";
                foreach($context as $item) {
                    $fallback .= "📍 **{$item->title}**: " . substr($item->content, 0, 200) . "...\n\n";
                }
                $fallback .= "\n*Por favor, pide al Administrador que configure `GEMINI_API_KEY` para darte respuestas completas.*";
            } else {
                $fallback .= "No encontré manuales relacionados con tu duda. Por favor, intenta ser más específico o solicita ayuda al personal de TI.";
            }
            
            return response()->json(['response' => $fallback]);
        }

        try {
            // Consumo de Gemini Pro (Máxima compatibilidad para resolver 404)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Eres GravityBot, el asistente de soporte técnico Inteligente de MChP (Misión Chilena del Pacífico). Tu personalidad es técnica, amigable y eficiente.
                            
                            INSTRUCCIONES:
                            1. Usa el CONTEXTO de manuales proporcionado abajo para responder.
                            2. Si la respuesta está en los manuales, dásela al usuario detalladamente.
                            3. Si NO está en los manuales, usa tu conocimiento general para ayudar, pero advierte que es una sugerencia general.
                            4. Responde siempre en Español.
                            5. Usa formato Markdown para que sea legible (negritas, listas, etc).
                            
                            CONTEXTO DE NUESTROS MANUALES:
                            " . ($contextText ?: "No hay manuales específicos para esta duda.") . "
                            
                            PREGUNTA DEL USUARIO:
                            {$prompt}"]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Lo siento, no pude procesar una respuesta coherente en este momento.';
                return response()->json(['response' => $text]);
            }

            // Error detallado para depuración
            $errorBody = $response->body();
            return response()->json([
                'response' => "Error en la conexión con la red neuronal de Gravity. Código: " . $response->status(),
                'debug' => $errorBody
            ]);

        } catch (\Exception $e) {
            return response()->json(['response' => 'Error crítico en el núcleo: ' . $e->getMessage()]);
        }
    }
}
