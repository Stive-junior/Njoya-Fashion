<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images_user extends Model
{
    use HasFactory;

    protected $table = 'images_users';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['user_id', 'url'];
    
    public function user() { return $this->belongsTo(User::class); }
}
