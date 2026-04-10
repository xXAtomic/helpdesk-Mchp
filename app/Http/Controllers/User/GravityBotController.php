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
        $response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}");
        
        return response()->json([
            'status' => $response->status(),
            'body' => $response->json()
        ]);
    }
}
