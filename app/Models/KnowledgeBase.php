<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model {
    protected $table = 'knowledge_bases';
    // ✅ ESTO ES LO MÁS IMPORTANTE PARA PODER GUARDAR:
    protected $fillable = ['title', 'content', 'icon'];
}
