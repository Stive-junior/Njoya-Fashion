<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * @property \Illuminate\Database\Eloquent\Collection $favorites
 */



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'number',
        'sexe',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relations

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'role_user')->withTimestamps();
    }

    public function adresses()
    {
        return $this->hasMany(Adresses::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorites::class, 'user_id');
    }

    public function profil()
    {
        return $this->hasOne(Images_user::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

  // Relation avec le panier
    public function panier()
    {
        return $this->hasOne(Panier::class,'user_id');
    }

    // Relation avec les articles dans le panier via panier_items
    public function panierItems()
    {
        return $this->hasManyThrough(Panier_items::class, Panier::class);
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'user_id');
    }

 
    public function hasRole($role)
    {
        return $this->roles->pluck('name')->contains($role);
    }

    
    public function hasPermission($permission)
    {
        return $this->permissions->pluck('name')->contains($permission)
            || $this->roles->flatMap->permissions->pluck('name')->contains($permission);
    }

   
 public function sessions()
    {
        return $this->hasMany(Session::class)->latest('last_activity');
    }


 public function scopeWithActiveSessions($query)
    {
        return $query->with(['sessions' => function($q) {
            $q->active()->select('user_id', 'last_activity');
        }]);
    }

public function isOnline()
    {
        return $this->sessions()->active()->exists();
    }


}
