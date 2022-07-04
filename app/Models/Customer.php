<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Address;
use App\Models\AliasAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model{
    protected $guarded = ['id'];

    use HasFactory;

    // order 
    public function orders(){
        return $this->hasMany(Order::class);
    }

    // address
    public function addresses(){
        return $this->hasMany(Address::class);
    }

    // default address
    public function defaultAddress(){
        return $this->hasOne(Address::class)->where('customer_id',$this->id)->where('default', 1);
    }

 

 
}
