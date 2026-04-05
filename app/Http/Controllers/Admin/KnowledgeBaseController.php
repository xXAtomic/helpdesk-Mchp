<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Knowledge;

class KnowledgeBaseController extends Controller
{
    public function index() {
        $manuals = Knowledge::orderBy('created_at', 'desc')->get();
        return view('admin.knowledge.index', compact('manuals'));
    }

    public function create() {
        return view('admin.knowledge.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'icon' => 'nullable'
        ]);

        Knowledge::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'icon' => $request->icon ?? '📖'
        ]);

        return redirect()->route('admin.knowledge.index')->with('success', 'Manual publicado correctamente.');
    }

    public function edit($id) {
        $manual = Knowledge::findOrFail($id);
        return view('admin.knowledge.edit', compact('manual'));
    }

    public function update(Request $request, $id) {
        $manual = Knowledge::findOrFail($id);
        
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'icon' => 'nullable'
        ]);

        $manual->update($data);

        return redirect()->route('admin.knowledge.index')->with('success', 'Manual actualizado con éxito.');
    }

    public function destroy($id) {
        $manual = Knowledge::findOrFail($id);
        $manual->delete();
        return redirect()->route('admin.knowledge.index')->with('success', 'Manual eliminado.');
    }
}
