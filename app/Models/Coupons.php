<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;

    protected $table = 'coupons';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    
     protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'max_uses',
        'used_count',
        'valid_from',
        'valid_until',
        'min_order_amount'
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2'
    ];
}
