<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalDocument;
use App\Models\DocumentSignature;
use Illuminate\Support\Str;

class ComplianceController extends Controller
{
    /**
     * Muestra la lista de documentos pendientes por firmar.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Documentos que el usuario ya firmó
        $signed = DocumentSignature::with('document')
            ->where('user_id', $user->id)
            ->where('is_accepted', true)
            ->get();

        $signedIds = $signed->pluck('legal_document_id')->toArray();

        // Documentos activos que no ha firmado
        $pending = LegalDocument::where('is_active', true)
            ->whereNotIn('id', $signedIds)
            ->get();

        return view('user.compliance.index', compact('pending', 'signed'));
    }

    /**
     * Muestra el documento específico para firmar.
     */
    public function show($id)
    {
        $document = LegalDocument::findOrFail($id);
        $signature = DocumentSignature::where('user_id', auth()->id())
            ->where('legal_document_id', $document->id)
            ->where('is_accepted', true)
            ->first();

        return view('user.compliance.show', compact('document', 'signature'));
    }

    /**
     * Procesa la firma digital (aceptación).
     */
    public function sign(Request $request, $id)
    {
        $document = LegalDocument::findOrFail($id);
        
        $request->validate([
            'accept_terms' => 'required|accepted',
        ]);

        DocumentSignature::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'legal_document_id' => $document->id,
            ],
            [
                'signed_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'is_accepted' => true,
                'signature_token' => Str::uuid()->toString(),
            ]
        );

        return redirect()->route('user.compliance.index')->with('success', 'Documento firmado correctamente. Gracias por tu compromiso.');
    }
}
