<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_Variant extends Model
{
    use HasFactory;

    protected $table = 'article_variants';
    
    protected $fillable = [
        'article_id',
        'sizes',
        'colors',
        'materials',
        'sku'
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'materials' => 'array'
    ];
    
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}