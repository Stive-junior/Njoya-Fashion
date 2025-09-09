<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $table = 'returns';
       protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    
    protected $fillable = [
        'order_item_id',
        'reason',
        'status',
        'refund_amount'
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2'
    ];

    // Relations
    public function orderItem()
    {
        return $this->belongsTo(Order_items::class);
    }

    public function user()
    {
        return $this->through('order_items', 'order')->belongsTo(User::class);
    }
}