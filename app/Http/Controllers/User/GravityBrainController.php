<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Knowledge;
use Illuminate\Http\Request;

class GravityBrainController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $suggestions = Knowledge::where('is_published', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->limit(3)
            ->get(['title', 'id']);

        return response()->json($suggestions);
    }
}
