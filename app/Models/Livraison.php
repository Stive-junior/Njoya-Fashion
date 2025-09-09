<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Livraison extends Model
{
    use HasFactory;

    protected $table = 'livraisons';
       protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    
    protected $fillable = [
        'order_id',
        'user_id',
        'address',
        'status',
        'livreur_id'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // Relations
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function livreur()
    {
        return $this->belongsTo(Livreur::class);
    }
}