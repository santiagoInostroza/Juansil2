<?php

namespace App\Models;

use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model{
    protected $guarded = ['id'];
    
    use HasFactory;

    //suppliers
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // purchase_items
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    // user_id_created
    public function userCreated()
    {
        return $this->belongsTo(User::class,'user_id_created');
    }
    // user_id_modified
    public function userModified()
    {
        return $this->belongsTo(User::class,'user_id_modified');
    }
}
