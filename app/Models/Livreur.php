<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    use HasFactory;

    protected $table = 'livreurs';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    
    protected $fillable = [
        'name',
        'delivery_range',
        'delivery_time',
        'user_id'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function livraisons()
    {
        return $this->hasMany(Livraison::class);
    }
}