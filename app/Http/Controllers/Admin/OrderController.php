<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Arr;
use App\Models\PurchaseItem;
use App\Models\MovementProduct;
use App\Models\OrderPurchaseItem;
use App\Http\Controllers\Controller;

class OrderController extends Controller{
    
    public function __construct(){
    
        $this->middleware('auth');
        $this->middleware('can:admin.orders.index')->only('index');
        $this->middleware('can:admin.orders.create')->only('create');
        $this->middleware('can:admin.orders.show')->only('show');
        $this->middleware('can:admin.orders.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');
    
    }
    public function index(){
        return view('admin.orders.index');
    }

    public function create(){
        return view('admin.orders.create');
    }

    public function show(Order $order){
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order){
        return view('admin.orders.edit', compact('order'));
    }


    // CREATE
    public function addItemToOrder(Product $product){    
        if(session()->has('order.items.'.$product->id) ){
            return false;
        }
        
        session([
            'order.items.'.$product->id => [
                'product_id' => $product->id,
                'name' => $product->name,
                'image_url' => $product->image->url,
                'stock' => $product->stock,
                'quantity' => '',
                'quantity_box' => $product->quantity_per_format,
                'total_quantity' => '',
                'price' => ($product->quantity_per_format > 0) ? ( $product->price / $product->quantity_per_format ):0,
                'price_box' => $product->price,
                'total_price' => '',
                
                
            ] 
        ]);  
        return true;
    }
    public function setItemFromOrder($product_id,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price){

        session()->put('order.items.'.$product_id.'.quantity', $quantity);
        session()->put('order.items.'.$product_id.'.quantity_box', $quantity_box);
        session()->put('order.items.'.$product_id.'.total_quantity', $total_quantity);
        session()->put('order.items.'.$product_id.'.price', $price);
        session()->put('order.items.'.$product_id.'.price_box', $price_box);
        session()->put('order.items.'.$product_id.'.total_price', $total_price);
        $this->getTotal();

    }
    public function removeItemFromOrder(Product $product){
        session()->forget('order.items.'.$product->id);
        $this->getTotal();
    }

    public function getTotal(){
      
        $total = 0;
        foreach (session('order.items') as $item) {
            $total += intval($item['total_price']);
        }
        session(['order.total' => $total]);
        
    }


    // EDIT
    public function addItemToEditOrder(Product $product, $items){    
        if(isset($items['items'][$product->id])){
            return false;
        }

        $items['items'][$product->id] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'image_url' => $product->image->url,
            'stock' => $product->stock,
            'quantity' => '',
            'quantity_box' => $product->quantity_per_format,
            'total_quantity' => '',
            'price' => ($product->quantity_per_format > 0) ? ( $product->price / $product->quantity_per_format ):0,
            'price_box' => $product->price,
            'total_price' => '',
            'total_quantity_old' => 0,
        ];
        
      
        return $items;
    }

    public function setItemFromEditOrder($product_id,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price, $items){

        $items['items'][$product_id]['product_id'] = $product_id;
        $items['items'][$product_id]['quantity'] = $quantity;

        $items['items'][$product_id]['quantity_box'] = $quantity_box;
        $items['items'][$product_id]['total_quantity'] = $total_quantity;
        $items['items'][$product_id]['price'] = $price;
        $items['items'][$product_id]['price_box'] = $price_box;
        $items['items'][$product_id]['total_price'] = $total_price;

        
        $response = $this->getTotalEditOrder($items);

        if ($response) {
           $items = $response;
        }

        return $items;

    }

    public function removeItemFromEditOrder(Product $product , $items){
      
        Arr::forget($items['items'],$product->id);
        $response = $this->getTotalEditOrder($items);

        if ($response) {
            $items = $response;
        }
        return $items;
    }

    public function getTotalEditOrder($items = null){
        if($items == null){
           return false;
        }
        $total = 0;
        foreach ($items['items'] as $item) {
            $total += intval($item['total_price']);
        }
       
        $items['total'] = $total;
        return $items;

    }

    


    public function getTotalSalesOfTheMonth($data = null){
        $month =  (isset($data['month'])) ? $data['month'] : now()->month;
        $year =  (isset($data['year'])) ? $data['year'] : now()->year;
        $type =  (isset($data['type'])) ? $data['type'] : 'all'; // all, paid, unpaid, cancelled, refunded, refunded_paid,  refunded_unpaid, 
        $operation =  (isset($data['operation'])) ? $data['operation'] : ''; // sum or avg or count or max or min or etc

        $data=[
            'month' => $month,
            'year' => $year,
            'type' => $type,
            'operation' => $operation,
        ];
       
        if($type == 'all'){
            $response = Order::where(function($query) use($data,){
                $query->where(function($q) use($data){
                    $q->where('delivery' , true)
                    ->whereMonth('delivery_date', $data['month'])
                    ->whereYear('delivery_date', $data['year'])
                    ->get();
                    })->orWhere(function($query) use($data){
                        $query->whereMonth('date',$data['month'])
                        ->whereYear('date',$data['year'])
                        ->get();
                    });
            });
        }

      
        if($operation == 'sum'){
            $response = $response->sum('total');
        }
        if($operation == 'count'){
            $response = $response->count();
        }
        return $response;


       



        
    }


    /*
        $orderData=[
            'customer_id' => $this->customer_id,
            'address_id' => $this->address_id,

            'date' => $this->date,

            'subtotal' => session('order.total'),

            'status' => $this->status,
            'sale_type' => 0,

            'payment_status' => $this->payment_status,
            'payment_amount' => $this->payment_amount,
            'payment_account' => $this->payment_account,
            'payment_account_comment' => $this->payment_account_comment,

            'delivery' => $this->delivery,
            'delivery_stage' => $this->delivery_stage,
            'delivery_value' => $this->delivery_value,
            'delivery_date' => $this->delivery_date,

            'is_invoice_delivered' => $this->is_invoice_delivered,
            'invoice_delivered_date' => $this->invoice_delivered_date,
            'user_id_invoice_delivered' => $this->user_id_invoice_delivered,

            'comment' => $this->comment,
        
        ];

        $items = [
            'product_id'
                'quantity'
                'quantity_box'
                'total_quantity'
                'price'
                'price_box'
                'total_price'
                'total_quantity'
        ]
    */
    public function save($data, $items){

        $customer_id = (isset($data['customer_id'])) ? $data['customer_id'] : null;
        $address_id = (isset($data['address_id'])) ? $data['address_id'] : null;

        $date = (isset($data['date'])) ? $data['date'] : now();

        $subtotal = (isset($data['subtotal'])) ? $data['subtotal'] : 0;        
        
        $status = (isset($data['status'])) ? $data['status'] : 0; //, [0=>'Agendado', 1=>'En proceso', 2=>'Entregado', 3=>'Pagado',4=>'Completado', 5=> 'Pausado', 6=> 'Reagendado', 7 => 'Anulado', 8 => 'Otro']);
        $sale_type = (isset($data['sale_type'])) ? $data['sale_type'] : 0;//,[0 =>'seller', 1 => 'online', 2 => 'special'])->default('seller');// 1 por ejecutivo, 2 online, 3  cliente especial
        
        // PAGO
        $payment_amount = (isset($data['payment_amount'])) ? $data['payment_amount'] : 0;
        $payment_status = (isset($data['payment_status'])) ? $data['payment_status'] : 0;// [ 0 => 'pendiente', 1 => 'abonado', 2=> 'pagado', 3=> 'other'])->nullable(); 
        $payment_account = (isset($data['payment_account'])) ? $data['payment_account'] : null;//[0 => 'Efectivo', 1=> 'Transferencia ', 2=>'Efectivo y transferencia', 3=> 'Otro'])->nullable(); //Cuenta de pago
        $payment_account_comment = (isset($data['payment_account_comment'])) ? $data['payment_account_comment'] : null;
        
        
        // DELIVERY
        $delivery = (isset($data['delivery'])) ? $data['delivery'] : false;
        $delivery_stage = (isset($data['delivery_stage'])) ? $data['delivery_stage'] : false; // etapa de entrega  0= por entregar\n1= entregado
        $delivery_value = (isset($data['delivery_value'])) ? $data['delivery_value'] : null;
        $delivery_date = (isset($data['delivery_date'])) ? $data['delivery_date'] : null;
        
        $total = $delivery_value + $subtotal;
        
        // FACTURA
        $is_invoice_delivered = (isset($data['is_invoice_delivered'])) ? $data['is_invoice_delivered'] : false;
        $invoice_delivered_date = (isset($data['invoice_delivered_date'])) ? $data['invoice_delivered_date'] : null;
        $user_id_invoice_delivered = (isset($data['user_id_invoice_delivered'])) ? $data['user_id_invoice_delivered'] : null;
                    
        $comment = (isset($data['comment'])) ? $data['comment'] : null;

       

        if($payment_status == 0){
            $payment_amount = 0;
            $pending_amount = $total;
            $payment_date = null;
            $user_id_paid = null;
        }

        if($payment_status == 1){
            $pending_amount = $total - $payment_amount;
            $payment_date = date('Y-m-d');
            $user_id_paid = auth()->user()->id;

        }

        if($payment_status == 2){
            $payment_amount = $total;
            $pending_amount = 0;
            $payment_date = date('Y-m-d');
            $user_id_paid = auth()->user()->id;
        }
           
        $date_delivered = ($delivery)?  date('Y-m-d H:i:s') : null ;
        $user_id_delivered = ($delivery)? auth()->user()->id : null ;
        

        $order = Order::create([
            
            'customer_id' => $customer_id,
            'address_id' => $address_id,
            'date' => $date,

            'subtotal' => $subtotal,

            'total' => $total,

            'status' => $status,
            'sale_type' => $sale_type,

            'payment_status' => $payment_status,
            'payment_account' => $payment_account,
            'payment_account_comment' => $payment_account_comment,
            'payment_amount' => $payment_amount,
            'pending_amount' => $pending_amount,
            'payment_date' => $payment_date,
            'user_id_paid' => $user_id_paid,
            'difference' => 0,
            'cost' => 0,

            
            'delivery' => $delivery,
            'delivery_stage' => $delivery_stage,
            'delivery_value' => $delivery_value,
            'delivery_date' => $delivery_date,
            'date_delivered' => $date_delivered,
            'user_id_delivery' => $user_id_delivered ,

            'is_invoice_delivered' => $is_invoice_delivered,
            'invoice_delivered_date' => $invoice_delivered_date,
            'user_id_invoice_delivered' => $user_id_invoice_delivered,


            'comment' => $comment,
            'user_id_created' => auth()->user()->id,
        ]);

               

        foreach ($items as $key => $item) {
            $orderItem = $order->orderItems()->create(
                [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'quantity_box' => $item['quantity_box'],
                    'total_quantity' => $item['total_quantity'],
                    'price' => $item['price'],
                    'price_box' => $item['price_box'],
                    'total_price' => $item['total_price'],
                    'stock' => $item['total_quantity'],
                    'cost'=> 0,
                    'total_cost'=> 0,
                    'difference'=> 0,
                    'total_difference'=> 0,
                ]
            );

           
            $orderItem = $this->createOrderPurchaseItem($orderItem->id);


             // INGRESAR MOVIMIENTO PENDIENTE
             $movementProduct = MovementProduct::create([
                'product_id' => $orderItem->product->id,
                'order_item_id' => $orderItem->id,
                'order_id' => $order->id,
                'type' => 2, //salida
                'name_type' => 2, //sale
                'date' => $date,
                'user_id_created' => auth()->user()->id,
                // 'stock' => $orderItem->product->stock,
            ]);
            

        }

        $orderItem->order->difference += $orderItem->order->delivery_value;
        $orderItem->order->save();
        
       

        return $orderItem->order;
        
    }

    public function update($order_id, $data, $items){
        $order = Order::find($order_id);

        $customer_id = (isset($data['customer_id'])) ? $data['customer_id'] : null;
        $address_id = (isset($data['address_id'])) ? $data['address_id'] : null;

        $date = (isset($data['date'])) ? $data['date'] : now();

        $subtotal = (isset($data['subtotal'])) ? $data['subtotal'] : 0;        
        
        $status = (isset($data['status'])) ? $data['status'] : 0; //, [0=>'Agendado', 1=>'En proceso', 2=>'Entregado', 3=>'Pagado',4=>'Completado', 5=> 'Pausado', 6=> 'Reagendado', 7 => 'Anulado', 8 => 'Otro']);
        $sale_type = (isset($data['sale_type'])) ? $data['sale_type'] : 0;//,[0 =>'seller', 1 => 'online', 2 => 'special'])->default('seller');// 1 por ejecutivo, 2 online, 3  cliente especial
        
        // PAGO
        $payment_amount = (isset($data['payment_amount'])) ? $data['payment_amount'] : 0;
        $payment_status = (isset($data['payment_status'])) ? $data['payment_status'] : 0;// [ 0 => 'pendiente', 1 => 'abonado', 2=> 'pagado', 3=> 'other'])->nullable(); 
        $payment_account = (isset($data['payment_account'])) ? $data['payment_account'] : null;//[0 => 'Efectivo', 1=> 'Transferencia ', 2=>'Efectivo y transferencia', 3=> 'Otro'])->nullable(); //Cuenta de pago
        $payment_account_comment = (isset($data['payment_account_comment'])) ? $data['payment_account_comment'] : null;
        
        
        // DELIVERY
        $delivery = (isset($data['delivery'])) ? $data['delivery'] : false;
        $delivery_stage = (isset($data['delivery_stage'])) ? $data['delivery_stage'] : false; // etapa de entrega  0= por entregar\n1= entregado
        $delivery_value = (isset($data['delivery_value'])) ? $data['delivery_value'] : null;
        $delivery_date = (isset($data['delivery_date'])) ? $data['delivery_date'] : null;
        
        $total = $delivery_value + $subtotal;
        
        // FACTURA
        $is_invoice_delivered = (isset($data['is_invoice_delivered'])) ? $data['is_invoice_delivered'] : false;
        $invoice_delivered_date = (isset($data['invoice_delivered_date'])) ? $data['invoice_delivered_date'] : null;
        $user_id_invoice_delivered = (isset($data['user_id_invoice_delivered'])) ? $data['user_id_invoice_delivered'] : null;
                    
        $comment = (isset($data['comment'])) ? $data['comment'] : null;

       

        if($payment_status == 0){
            $payment_amount = 0;
            $pending_amount = $total;
            $payment_date = null;
            $user_id_paid = null;
        }

        if($payment_status == 1){
            $pending_amount = $total - $payment_amount;
            $payment_date = date('Y-m-d');
            $user_id_paid = auth()->user()->id;

        }

        if($payment_status == 2){
            $payment_amount = $total;
            $pending_amount = 0;
            $payment_date = date('Y-m-d');
            $user_id_paid = auth()->user()->id;
        }
           
        $date_delivered = ($delivery)?  date('Y-m-d H:i:s') : null ;
        $user_id_delivered = ($delivery)? auth()->user()->id : null ;
        
        $order->update([
            'customer_id' => $customer_id,
            'address_id' => $address_id,
            'date' => $date,

            'subtotal' => $subtotal,

            'total' => $total,

            'status' => $status,
            'sale_type' => $sale_type,

            'payment_status' => $payment_status,
            'payment_account' => $payment_account,
            'payment_account_comment' => $payment_account_comment,
            'payment_amount' => $payment_amount,
            'pending_amount' => $pending_amount,
            'payment_date' => $payment_date,
            'user_id_paid' => $user_id_paid,
            'difference' => 0,
            'cost' => 0,

            
            'delivery' => $delivery,
            'delivery_stage' => $delivery_stage,
            'delivery_value' => $delivery_value,
            'delivery_date' => $delivery_date,
            'date_delivered' => $date_delivered,
            'user_id_delivery' => $user_id_delivered ,

            'is_invoice_delivered' => $is_invoice_delivered,
            'invoice_delivered_date' => $invoice_delivered_date,
            'user_id_invoice_delivered' => $user_id_invoice_delivered,


            'comment' => $comment,
            'user_id_modified' => auth()->user()->id,
        ]);

        // foreach ($order->orderItems as $key => $item) {
        //     $item->product->stock += $item->stock;
        //     $item->product->save();


        // }

        // DEVOLVIENDO STOCK A PURCHASEITEM Y PRODUCTS
        $this->deleteItemsFromOrder($order);
        

        foreach ($items as $product_id => $item) {
            $orderItem = $order->orderItems()->create(
                [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'quantity_box' => $item['quantity_box'],
                    'total_quantity' => $item['total_quantity'],
                    'price' => $item['price'],
                    'price_box' => $item['price_box'],
                    'total_price' => $item['total_price'],
                    'stock' => $item['total_quantity'],
                    'cost'=> 0,
                    'total_cost'=> 0,
                    'difference'=> 0,
                    'total_difference'=> 0,
                ]
            );

            //    CREATE ORDERPURCHASEITEM AND UPDATE STOCKS
            $orderItem = $this->createOrderPurchaseItem($orderItem->id);



             // ACTUALIZAR MOVIMIENTO PENDIENTE
             $movementProduct = MovementProduct::where('order_id',$order->id)->where('product_id',$item['product_id'])->first();

            if ($movementProduct) {
                $movementProduct->order_item_id = $orderItem->id;
                $movementProduct->user_id_modified = auth()->user()->id;
                $movementProduct->save();
            }else{
                 // INGRESAR MOVIMIENTO PENDIENTE
                $movementProduct = MovementProduct::create([
                    'product_id' => $orderItem->product->id,
                    'order_item_id' => $orderItem->id,
                    'order_id' => $orderItem->order->id,
                    'type' => 2, //salida
                    'name_type' => 2, //sale
                    'date' => date('Y-m-d'),
                    'user_id_created' => auth()->user()->id,
                ]);
            }


            
            
            

        }

        
        $orderItem->order->difference += $orderItem->order->delivery_value;
        $orderItem->order->save();

        return $orderItem->order;
        
    }

    public function deleteOrder($id){
        $order = Order::findOrFail($id);
        if ($order) {
            $this->deleteItemsFromOrder($order);
        }
        $order->delete();
        return $order;
    }

    public function deleteItemsFromOrder($order){
        // DEVOLVIENDO STOCK A PURCHASEITEM Y PRODUCTS
        foreach ($order->orderItems as $orderItem) {
            foreach ($orderItem->orderPurchaseItems as $orderPurchaseItem) {
                 $orderPurchaseItem->purchaseItem->stock+= $orderPurchaseItem->quantity;
                 $orderPurchaseItem->purchaseItem->save();
 
                 $orderPurchaseItem->product->stock += $orderPurchaseItem->quantity;
                 $orderPurchaseItem->product->save();
            }
         }
 
         $order->orderItems()->delete();    
    }

    public function createOrderPurchaseItem($order_item_id , $quantity = null){
        $orderItem = OrderItem::findOrFail($order_item_id);
        
        $total_quantity = (isset($quantity) && $quantity >0) ? $quantity : $orderItem->total_quantity;
        $totalCost = 0;
        $totalDifference = 0;
       

        while ($total_quantity > 0) {

            $purchaseItem = PurchaseItem::where('product_id',$orderItem->product_id)->where('stock', '>',0)->orderBy('purchase_id','asc')->first();
      

            $cost=0;
            $difference=0;

            if($total_quantity <= $purchaseItem->stock){

                $purchaseItem->stock -= $total_quantity;
                $purchaseItem->save();

                $cost = $purchaseItem->price * $total_quantity;
                $difference = ($orderItem->price - $purchaseItem->price) * $total_quantity;

                OrderPurchaseItem::create([
                    'order_item_id' => $orderItem->id,
                    'purchase_item_id' => $purchaseItem->id,
                    'product_id' => $orderItem->product_id,
                    'total_quantity' => $orderItem->total_quantity,
                    'quantity' => $total_quantity,
                    'cost' => $cost,
                    'difference' => $difference,
                ]);

                $total_quantity = 0;

            }else{

                $cost = $purchaseItem->price * $purchaseItem->stock;
                $difference = ($orderItem->price - $purchaseItem->price) * $purchaseItem->stock;
                
                OrderPurchaseItem::create([
                    'order_item_id' => $orderItem->id,
                    'purchase_item_id' => $purchaseItem->id,
                    'product_id' => $orderItem->product_id,
                    'total_quantity' => $orderItem->total_quantity,
                    'quantity' => $purchaseItem->stock,
                    'cost' => $cost,
                    'difference' => $difference,
                ]);
                
                $total_quantity -= $purchaseItem->stock;
                
                $purchaseItem->stock = 0;
                $purchaseItem->save();


            }

            $totalCost += $cost;
            $totalDifference += $difference;

        }  

        $orderItem->total_cost = $totalCost ;
        $orderItem->total_difference = $totalDifference;
        $orderItem->cost = $purchaseItem->price ;
        $orderItem->difference = $orderItem->price - $purchaseItem->price;
        $orderItem->save();


        foreach ($orderItem->orderPurchaseItems as $orderPurchaseItem) {

            $orderItem->order->cost += $orderPurchaseItem->cost;
            $orderItem->order->difference += $orderPurchaseItem->difference;
            $orderItem->order->save();
        }
        
        
        $orderItem->product->stock -=(isset($quantity) && $quantity >0) ? $quantity : $orderItem->total_quantity;
        $orderItem->product->save();

        

        return $orderItem;

    }







}
