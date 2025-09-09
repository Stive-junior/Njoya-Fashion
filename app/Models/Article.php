<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';
    protected $fillable = [
        'name', 
        'description', 
        'base_price', 
        'category_id'
    ];
    
    protected $casts = [
        'base_price' => 'decimal:2'
    ];


public function usersPanier()
{
     return $this->belongsToMany(User::class, 'panier_items', 'article_id', 'panier_id')
        ->using(Panier_items::class)
        ->withPivot('quantity')
        ->withTimestamps();
}

public function isInActiveCarts(): bool
{
    return $this->panierItems()
        ->whereHas('panier', function ($query) {
            $query->where('expires_at', '>', now());
        })
        ->exists();
}


public function usersWithArticleInCart()
{
    return User::whereHas('panier.items', function($query) {
            $query->where('article_id', $this->id)
                  ->whereHas('panier', function($q) {
                      $q->valid(); // Utilise le scope valid (expires_at > now())
                  });
        })
        ->withActiveSessions()
        ->select(['id', 'name', 'email'])
        ->get()
        ->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_online' => $user->isOnline()
            ];
        });
}




public function getCartUsersWithStatus()
{
   return $this->belongsToMany(User::class, 'panier_items', 'article_id', 'panier_id')
        ->join('paniers', 'paniers.id', '=', 'panier_items.panier_id')
        ->where('paniers.expires_at', '>', now())
        ->with(['sessions' => function($query) {
            $query->where('last_activity', '>=', now()->subMinutes(
                config('session.lifetime', 120)
            ));
        }])
        ->select(['users.id', 'users.name', 'users.email'])
        ->distinct()
        ->get()
        ->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_online' => $user->sessions->isNotEmpty()
            ];
        });
}


public function getCartUsers()
{
    return $this->belongsToMany(User::class, 'panier_items', 'article_id', 'panier_id')
        ->join('paniers', 'paniers.id', '=', 'panier_items.panier_id')
        ->where('paniers.expires_at', '>', now())
        ->with(['sessions' => function($query) {
            $query->activeSessions();
        }])
        ->select(['users.id', 'users.name', 'users.email'])
        ->distinct()
        ->get()
        ->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_online' => $user->sessions->isNotEmpty()
            ];
        });
}


    public function category() { return $this->belongsTo(Categories::class); }
    public function variants() { return $this->hasMany(Article_Variant::class); }
    public function images() { return $this->hasMany(Images::class); }
    public function orderItems() { return $this->hasMany(Order_items::class); }
    public function favorites() { return $this->hasMany(Favorites::class); }
    public function reviews() { return $this->hasMany(Reviews::class); }
    public function panierItems() { return $this->hasMany(Panier_items::class); }
}