<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\OrderItem;
use App\Models\OrderPurchaseItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends Model{
    protected $guarded = ['id'];
    use HasFactory;

    public function orderPurchaseItems(){
        return $this->hasMany(OrderPurchaseItem::class);
    }
    
    // oreder_items
    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class);
    }

    // purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // product
    public function product(){
        return $this->belongsTo(Product::class);
    }



}

