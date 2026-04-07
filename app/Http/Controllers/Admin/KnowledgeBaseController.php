<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Knowledge;
use Illuminate\Support\Str;

class KnowledgeBaseController extends Controller
{
    public function index() {
        $manuals = Knowledge::whereNotIn('category', ['Recomendación', 'Tip'])->orderBy('created_at', 'desc')->get();
        $tips = Knowledge::whereIn('category', ['Recomendación', 'Tip'])->orderBy('created_at', 'desc')->get();
        return view('admin.knowledge.index', compact('manuals', 'tips'));
    }

    public function create() {
        return view('admin.knowledge.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required|string',
            'icon' => 'nullable',
            'file' => 'nullable|file|max:10240'
        ]);

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('knowledge_files', 'public');
        }

        Knowledge::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'content' => $data['content'],
            'category' => $data['category'],
            'icon' => $request->icon ?? '📖',
            'file_path' => $filePath,
            'file_name' => $fileName,
            'is_published' => true,
        ]);

        return redirect()->route('admin.knowledge.index')->with('success', 'Publicado correctamente.');
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
            'category' => 'required|string',
            'icon' => 'nullable',
            'file' => 'nullable|file|max:10240'
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('file')) {
            // Eliminar archivo anterior si existe
            if ($manual->file_path && \Storage::disk('public')->exists($manual->file_path)) {
                \Storage::disk('public')->delete($manual->file_path);
            }
            $file = $request->file('file');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $file->store('knowledge_files', 'public');
        }

        $manual->update($data);

        return redirect()->route('admin.knowledge.index')->with('success', 'Manual actualizado con éxito.');
    }

    public function destroy($id) {
        $manual = Knowledge::findOrFail($id);
        $manual->delete();
        return redirect()->route('admin.knowledge.index')->with('success', 'Manual eliminado.');
    }
}
