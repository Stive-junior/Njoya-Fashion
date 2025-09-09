<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier_items extends Model
{
    use HasFactory;

    protected $table = 'panier_items';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    
    protected $fillable = [
        'panier_id',
        'article_id',
        'quantity',
        'custom_message',
        'variants',
        'variant_quantities'
    ];

    protected $casts = [
        'variants' => 'array',
        'variant_quantities' => 'array'
    ];


  
    public function panier() { return $this->belongsTo(Panier::class); }
    public function article() { return $this->belongsTo(Article::class); }
}
