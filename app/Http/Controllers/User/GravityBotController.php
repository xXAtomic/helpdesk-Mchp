<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GravityBotController extends Controller
{
    public function chat(Request $request)
    {
        $apiKey = config('services.gemini.key');
        // Probamos v1beta
        $response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}");
        
        $models = [];
        if (isset($response->json()['models'])) {
            foreach($response->json()['models'] as $m) {
                $models[] = $m['name'];
            }
        }

        return response()->json([
            'response' => "📡 MODELOS ENCONTRADOS:\n" . implode("\n", $models) ?: "No se encontraron modelos o la API KEY es inválida. Status: " . $response->status()
        ]);
    }
}
