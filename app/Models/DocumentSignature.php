<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentSignature extends Model
{
    protected $fillable = [
        'user_id', 
        'legal_document_id', 
        'asset_id', 
        'signed_at', 
        'ip_address', 
        'user_agent', 
        'is_accepted', 
        'signature_token'
    ];

    protected $casts = [
        'signed_at' => 'datetime',
        'is_accepted' => 'boolean',
    ];

    public function document()
    {
        return $this->belongsTo(LegalDocument::class, 'legal_document_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
