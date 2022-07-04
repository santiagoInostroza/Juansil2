<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller{
    public function catalog(){
        return view('products.catalog');
    }

    public function wholesale(){
        return view('products.wholesale');
    }

    public function addItemToCartWS($product_id){
      
        $product = Product::with('image')->find($product_id);

        
        session([
            'cart.ws.items.'.$product->id => [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image->url,
                'format' => $product->format->name,
            ]
        ]);

        $this->getTotal();
    }

    public function getTotal(){
        $total = 0;
        $cantTotal = 0;
        foreach(session('cart.ws.items') as $item){
            $total += $item['price'] * $item['quantity'];
            $cantTotal += $item['quantity'];
        }
        session(['cart.ws.total' => $total]);
        session(['cart.ws.cantTotal' => $cantTotal]);
        return $total;
    }

    public function removeItemFromCartWS($product_id){
        session()->forget('cart.ws.items.'.$product_id);
        
        $this->getTotal();
        if (count(session('cart.ws.items')) == 0){
            session()->forget('cart');
        }
    }

    public function setItemFromCartWS($product_id, $quantity){
        session()->put('cart.ws.items.'.$product_id.'.quantity', $quantity);
        $this->getTotal();
    }
}
