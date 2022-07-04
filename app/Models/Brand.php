<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model{
    use HasFactory;
    protected $guarded = ['id'];

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
