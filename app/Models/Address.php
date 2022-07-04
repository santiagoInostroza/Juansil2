<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model{
    use HasFactory;
    protected $guarded = ['id'];

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    // customers
    public function customers(){
        return $this->belongsTo(Customer::class);
    }

    // orders
    public function orders(){
        return $this->hasMany(Order::class);
    }

   
}
