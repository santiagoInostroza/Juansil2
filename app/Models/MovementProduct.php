<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovementProduct extends Model{

    protected $guarded = ['id'];
    use HasFactory;

    // function product
    public function product(){
        return $this->belongsTo(Product::class);
    }

  


}
