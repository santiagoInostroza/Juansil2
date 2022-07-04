<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderItem;
use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model{   
    protected $guarded = ['id'];

    use HasFactory;

    //orderItems
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    // customers
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // users_id who paid
    public function userPaid()
    {
        return $this->belongsTo(User::class,'user_id_paid');
    }

    // user_id_delivered
    public function userDelivered()
    {
        return $this->belongsTo(User::class,'user_id_delivered');
    }

    // user_id_invoice_delivered
    public function userInvoiceDelivered()
    {
        return $this->belongsTo(User::class,'user_id_invoice_delivered');
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
