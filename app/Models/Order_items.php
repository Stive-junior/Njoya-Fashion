<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    use HasFactory;

    protected $table = 'order_items';
        protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    
    
     protected $fillable = [
        'order_id',
        'article_id',
        'quantity',
        'unit_price'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2'
    ];

  
    public function order() { return $this->belongsTo(Order::class); }
    public function article() { return $this->belongsTo(Panier_items::class, 'article_id'); }
    public function retour() { return $this->hasOne(Returns::class); }
}
