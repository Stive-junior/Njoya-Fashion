<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $table = 'paniers';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    
    protected $fillable = [
        'user_id',
        'session_id',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

  
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(Panier_items::class); }

 
   public function getTotal()
    {
        return $this->items->sum(fn($item) => $item->quantity * $item->article->base_price);
    }

    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now());
    }

    public function scopeHasUser($query)
    {
        return $query->with('user');
    }
}
