<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $table = 'reviews';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    
    protected $fillable = [
        'user_id',
        'article_id',
        'rating',
        'comment'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    // Relations
    public function user() { return $this->belongsTo(User::class); }
    public function article() { return $this->belongsTo(Article::class); }
}
