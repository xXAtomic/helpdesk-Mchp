<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Knowledge;
use App\Models\TicketDeflection;
use Illuminate\Http\Request;

class GravityBrainController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $suggestions = Knowledge::where('is_published', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'title', 'content', 'category', 'icon', 'file_path', 'file_name']);

        return response()->json($suggestions);
    }

    public function deflect(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'article_id' => 'nullable|integer',
            'method' => 'required|in:ARTICLE,AI_BOT'
        ]);

        TicketDeflection::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'article_id' => $request->article_id,
            'method' => $request->input('method')
        ]);

        return response()->json(['status' => 'success', 'message' => 'Deflection recorded.']);
    }
}
