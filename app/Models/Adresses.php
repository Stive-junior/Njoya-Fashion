<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresses extends Model
{
    use HasFactory;


    protected $table = 'adresses';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;


    protected $fillable = [
        'user_id',
        'street', 
        'city',
        'country'
    ];

    // Relation
    public function user() { return $this->belongsTo(User::class,'user_id'); }
}
