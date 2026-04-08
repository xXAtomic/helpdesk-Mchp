<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    protected $fillable = [
        'title', 
        'slug', 
        'content', 
        'version', 
        'is_active', 
        'requires_asset'
    ];

    public function signatures()
    {
        return $this->hasMany(DocumentSignature::class);
    }
}
