<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    use HasFactory;

    protected $table = 'promotions';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    
    protected $fillable = [
        'name',
        'discount_type',
        'discount_value',
        'applies_to',
        'target_id',
        'start_date',
        'end_date',
        'min_order_amount'
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function target()
    {
        return $this->morphTo();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

 
    public function active()
    {
        $now = now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }
}