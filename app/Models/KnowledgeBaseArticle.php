<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeBaseArticle extends Model
{
    use HasFactory;

    protected $table = 'knowledge_base_articles';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'author_id',
        'is_published',
        'views'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
