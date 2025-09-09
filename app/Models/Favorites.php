<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{

    use HasFactory;

    protected $table = 'favorites';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    
    protected $fillable = [
        'user_id',
        'article_id'
    ];

  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
