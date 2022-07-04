<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderPurchaseItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model{
    protected $guarded = ['id'];
    use HasFactory;

    // order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // purchase_items
    public function purchaseItems()
    {
        return $this->belongsToMany(PurchaseItem::class);
    }

    // order_purchase_items
    public function orderPurchaseItems()
    {
        return $this->hasMany(OrderPurchaseItem::class);
    }
}
