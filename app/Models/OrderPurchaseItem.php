<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPurchaseItem extends Model{
    protected $guarded = ['id'];
    use HasFactory;

    public function purchaseItem(){
        return $this->belongsTo(PurchaseItem::class);
    }

    // orderItem
    public function orderItem(){
        return $this->belongsTo(OrderItem::class);
    }

    // product
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
