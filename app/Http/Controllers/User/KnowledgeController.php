<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Knowledge;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index()
    {
        $articles = Knowledge::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.knowledge.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Knowledge::where('id', $id)
            ->where('is_published', true)
            ->firstOrFail();
            
        return view('user.knowledge.show', compact('article'));
    }
}
