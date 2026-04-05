<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeBaseArticle extends Model
{
    use HasFactory;

    protected $table = 'knowledge_manuals';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'is_published',
    ];

    public function ticket_category()
    {
        return $this->belongsTo(TicketCategory::class, 'category', 'slug');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
