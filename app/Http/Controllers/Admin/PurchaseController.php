<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller{

    public function __construct(){

        $this->middleware('auth');
        $this->middleware('can:admin.purchases.index')->only('index');
        $this->middleware('can:admin.purchases.create')->only('create');
        $this->middleware('can:admin.purchases.show')->only('show');
        $this->middleware('can:admin.purchases.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');

    }

    public function index(){
        return view('admin.purchases.index');
    }

    public function details(){
        return view('admin.purchases.details');
    }
    
     public function create(){
         return view('admin.purchases.create');
     }
    
     public function show(Purchase $purchase){
         return view('admin.purchases.show', compact('purchase'));
     }
    
     public function edit(Purchase $purchase){
         return view('admin.purchases.edit', compact('purchase'));
     }

    public function delete(Purchase $purchase){
        foreach ($purchase->purchaseItems as $key => $item) {
            $item->product->stock -= $item->total_quantity;
            $item->product->save();
        }
        $purchase->delete();
    }

    public function addProductToSession($product_id){
        $product = Product::with('image')->find($product_id);

        if(session()->has('purchase.items.'.$product->name) ){
            return false;
        }
        session([
            'purchase.items.'.$product->name => [
                'product_id' => $product->id,
                'name' => $product->name,
                'image_url' => $product->image->url,
                'stock' => $product->stock,
                'quantity' => '',
                'quantity_box' => '',
                'total_quantity' => '',
                'price' => '',
                'total_price' => '',
                'price_box' => '',
                'expired_date' => null,
                
            ] 
        ]);  
        return $product;
    }

    public function removeFromSession($product_name){
        session()->forget('purchase.items.'.$product_name);
        $this->getTotal();
    }

    public function getTotal(){
        $total = 0;
        foreach (session('purchase.items') as $key => $item) {
            $total+= intval($item['total_price']);
        }
        session(['purchase.total' =>$total]);
    
    }
 

    public function setPurchase($key,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price,$expired_date){
        

        session()->put('purchase.items.'.$key.'.quantity', $quantity);
        session()->put('purchase.items.'.$key.'.quantity_box', $quantity_box);
        session()->put('purchase.items.'.$key.'.total_quantity', $total_quantity);
        session()->put('purchase.items.'.$key.'.price', $price);
        session()->put('purchase.items.'.$key.'.price_box', $price_box);
        session()->put('purchase.items.'.$key.'.total_price', $total_price);
        session()->put('purchase.items.'.$key.'.expired_date', $expired_date);
        

        $this->getTotal();

        return session('purchase.items.'.$key);
    }
   

   

    
}
