<?php

namespace App\Models;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model{
    protected $guarded = ['id'];
    use HasFactory;

    // purchases
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
