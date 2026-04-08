<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalDocument;
use App\Models\DocumentSignature;
use Illuminate\Support\Str;

class ComplianceController extends Controller
{
    public function index()
    {
        $documents = LegalDocument::withCount('signatures')->get();
        return view('admin.compliance.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.compliance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        LegalDocument::create([
            'title'          => $request->input('title'),
            'slug'           => Str::slug($request->input('title')),
            'content'        => $request->input('content'),
            'version'        => $request->input('version', '1.0'),
            'requires_asset' => $request->has('requires_asset'),
            'is_active'      => true
        ]);

        return redirect()->route('admin.compliance.index')->with('success', 'Documento legal registrado correctamente.');
    }

    public function show($id)
    {
        $document = LegalDocument::with('signatures.user', 'signatures.asset')->findOrFail($id);
        return view('admin.compliance.show', compact('document'));
    }

    public function edit($id)
    {
        $document = LegalDocument::findOrFail($id);
        return view('admin.compliance.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $document = LegalDocument::findOrFail($id);
        
        $document->update([
            'title'          => $request->input('title'),
            'content'        => $request->input('content'),
            'version'        => $request->input('version'),
            'requires_asset' => $request->has('requires_asset'),
            'is_active'      => $request->has('is_active'),
        ]);

        return redirect()->route('admin.compliance.index')->with('success', 'Documento actualizado.');
    }
}
