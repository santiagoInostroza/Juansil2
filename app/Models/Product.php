<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Image;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\ProductFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model{
    protected $guarded = ['id'];
    use HasFactory;

    // protected $casts = [
    //     'image' => 'array',
    //     'attachments' => 'array',
    // ];

   

    // public function image(){
    //     return $this->morphMany(Image::class, 'imageable');
    // }

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }
    
    public function brand(){
        return $this->belongsTo(Brand::class);
    }



    //    categories
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    // order_item
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function format(){
        return $this->belongsTo(ProductFormat::class, 'product_format_id');
    }

    //function movementProduct
    public function movementProducts(){
        return $this->hasMany(MovementProduct::class);
    }


}
