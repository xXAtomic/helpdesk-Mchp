<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GravityAIService;

class GravityBotController extends Controller
{
    protected $aiService;

    public function __construct(GravityAIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Procesa la interacción del chat con el usuario.
     */
    public function chat(Request $request)
    {
        $prompt = $request->input('prompt');

        // 1. Obtener contexto relevant (RAG)
        $context = $this->aiService->getKnowledgeContext($prompt);
        $contextText = $context->map(fn($item) => "MANUAL: {$item->title}\nPROCEDIMIENTO: {$item->content}")->implode("\n---\n");

        // 2. Generar respuesta usando el servicio AI
        $response = $this->aiService->askAI($prompt, $contextText);

        return response()->json(['response' => $response]);
    }
}
