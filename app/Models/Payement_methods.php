<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payement_methods extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    
    protected $fillable = [
        'name',
        'is_active',
        'numero',
        'logo'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get the orders associated with the payment method.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
