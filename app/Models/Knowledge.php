<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Knowledge extends Model
{
    use HasFactory;

    protected $table = 'knowledge_manuals';

    protected $fillable = [
        'title',
        'icon',
        'slug',
        'content',
        'category',
        'is_published',
        'file_path',
        'file_name'
    ];
}
