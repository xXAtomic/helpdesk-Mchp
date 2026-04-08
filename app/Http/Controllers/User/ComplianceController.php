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

        // Documentos activos que no ha firmado y que corresponden a su entidad
        $pending = LegalDocument::where('is_active', true)
            ->whereNotIn('id', $signedIds)
            ->where(function($q) use ($user) {
                if ($user->entity === 'BOTH') {
                    $q->whereIn('entity', ['IASD', 'FESDG', 'BOTH', null]);
                } else {
                    $q->whereIn('entity', [$user->entity, 'BOTH', null]);
                }
            })
            ->get();

        return view('user.compliance.index', compact('pending', 'signed'));
    }

    /**
     * Muestra el documento específico para firmar con vista previa dinámica.
     */
    public function show($id)
    {
        $document = LegalDocument::findOrFail($id);
        $user = auth()->user();
        
        $signature = DocumentSignature::where('user_id', $user->id)
            ->where('legal_document_id', $document->id)
            ->where('is_accepted', true)
            ->first();

        // Datos de la entidad para la vista previa
        $entityData = $this->getEntityData($user->entity);
        $assets = $user->assets;

        return view('user.compliance.show', compact('document', 'signature', 'entityData', 'assets'));
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
                'signature_token' => (string) Str::uuid(),
            ]
        );

        return redirect()->route('user.compliance.index')->with('success', 'Documento firmado correctamente. Gracias por tu compromiso.');
    }

    /**
     * Genera y descarga el PDF del acta.
     */
    public function downloadPDF($id)
    {
        $document = LegalDocument::findOrFail($id);
        $user = auth()->user();
        $assets = $user->assets;
        
        // Buscamos la firma certificada
        $signature = DocumentSignature::where('user_id', $user->id)
            ->where('legal_document_id', $document->id)
            ->where('is_accepted', true)
            ->first();

        $entityData = $this->getEntityData($user->entity);

        $data = [
            'document' => $document,
            'user' => $user,
            'assets' => $assets,
            'signature' => $signature,
            'entity_name' => $entityData['name'],
            'entity_rut' => $entityData['rut'],
            'entity_full_name' => $entityData['full_name'],
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('documents.receipt_devolution', $data);
        
        return $pdf->download("Acta_{$document->slug}_{$user->name}.pdf");
    }


    /**
     * Retorna los datos estáticos de la entidad.
     */
    private function getEntityData($entity)
    {
        if ($entity === 'FESDG') {
            return [
                'name' => 'FESDG',
                'full_name' => 'Fundación Educacional Sanders de Groot',
                'rut' => '65.102.254-1'
            ];
        }

        return [
            'name' => 'IASD',
            'full_name' => 'Misión Chilena del Pacífico',
            'rut' => '65.002.737-K'
        ];
    }
}

