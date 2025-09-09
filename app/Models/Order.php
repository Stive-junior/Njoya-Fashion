<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


   class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    
    protected $fillable = [
    'user_id',
    'total_amount',
    'status',
    'payment_method_id',
    'payment_reference',
    'shipping_address',
    'partial_amount'
];


protected $casts = [
    'partial_amount'=> 'decimal:2',
    'total_amount' => 'decimal:2',
    'status' => 'string',
    'shipping_address' => 'array'
];


public function markAsPaid($reference)
{
    $this->update([
        'status' => 'paid',
        'payment_reference' => $reference,
        'payment_verified_at' => now()
    ]);
}


    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Order_items::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Payement_methods::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotions::class);
    }

    public function livraison()
    {
        return $this->hasOne(Livraison::class);
    }
}
