<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GravityAIService;

class GravityBrainController extends Controller
{
    protected $aiService;

    public function __construct(GravityAIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Motor de búsqueda instantánea para sugerencias mientras el usuario escribe.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $suggestions = $this->aiService->getKnowledgeContext($query, 5);

        return response()->json($suggestions);
    }

    /**
     * Registra cuando un usuario evita crear un ticket gracias a la IA o Manuales.
     */
    public function deflect(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'article_id' => 'nullable|integer',
            'method' => 'required|in:ARTICLE,AI_BOT'
        ]);

        $this->aiService->recordDeflection($validated);

        return response()->json(['status' => 'success', 'message' => 'Deflection recorded.']);
    }
}
