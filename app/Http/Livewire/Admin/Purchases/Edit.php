<?php

namespace App\Http\Livewire\Admin\Purchases;

use App\Models\Product;
use Livewire\Component;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Arr;
use App\Models\MovementProduct;
use App\Models\OrderPurchaseItem;
use Illuminate\Contracts\Validation\Rule;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Models\OrderItem;

class Edit extends Component{

    public $purchase;
    public $items;

    public $name;
    public $redirect;

    public $products;
    public $suppliers;

    public $productModal;
    public $supplierModal;

    public $product_id;
    public $supplier_id;
    public $date;
    public $total;
    public $comment;



    public $listeners=[
        'closeProductModal',
        'addProductToSession',
        'closeSupplierModal',
    ];

    public function mount($redirect = true){
        $this->redirect = $redirect;
        $this->productModal = false;
        $this->supplierModal = false;
        $this->purchase->date = date('Y-m-d',strtotime($this->purchase->date)) . 'T' . date('H:i',strtotime($this->purchase->date)) ;

        $this->items = $this->purchase->purchaseItems()->with(['product','product.image'])->get()->toArray();
        
        $this->total = $this->purchase->total;



    }

    protected $rules = [
      
        'purchase.supplier_id' => 'required|integer|exists:suppliers,id',
        'purchase.date' => 'required|date',
        'purchase.comment' => 'nullable|string',
    ];

    public function addProductToSession($product){

        // $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'product','consolelog2' => $product ]);
        $product = Product::with('image')->find($product['id']);

        foreach ($this->items as $item) {

            if ($item['product_id'] == $product->id ){
                $this->dispatchBrowserEvent('salert',[
                    'title' =>  $product->name . ' ya está agregado a la lista',
                    'icon' => 'warning',
                    'position' => 'top',
                    'toast' => true,
                    'timer' => 2400,
                ]);
              return false;
            }
           
        }

        $this->items[] = [
            'product' => 
                [
                    'id' => $product->id,
                    'image' => ['url' => $product->image->url ],
                    'name' => $product->name,
                    'stock' => $product->stock,
                ],
            'product_id' => $product->id,
            'stock' => $product->stock,
            'quantity' => '',
            'quantity_box' => '',
            'total_quantity' => '',
            'price' => '',
            'total_price' => '',
            'price_box' => '',
            
        ];  

        $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'name', 'consolelog2' => $this->items]);


        $this->dispatchBrowserEvent('salert',[
            'title' =>  $product->name . ' agregado a la lista',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);

    }

    public function removeFromPurchase($key,$name){
        $this->dispatchBrowserEvent('consolelog',[ 'consolelog' =>1, 'consolelog2' =>  $this->items]);
        Arr::forget($this->items, $key);
        $this->dispatchBrowserEvent('consolelog',[ 'consolelog' =>2, 'consolelog2' =>  $this->items]);
        $this->getTotal();

        $this->dispatchBrowserEvent('salert',[
            'title' =>  $name . ' eliminado de la lista',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
            ]);
    }

    public function setPurchase($key,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price){
      
        $this->items[$key]['quantity'] = $quantity;
        $this->items[$key]['quantity_box'] = $quantity_box;
        $this->items[$key]['total_quantity'] = $total_quantity;
        $this->items[$key]['price'] = $price;
        $this->items[$key]['price_box'] = $price_box;
        $this->items[$key]['total_price'] = $total_price;
           
        $this->getTotal();
    }

    public function getTotal(){
        $total = 0;
        foreach ($this->items as $key => $item) {
            $total+= intval($item['total_price']);
        }
        $this->total = $total;
    }
    


    

    public function closeProductModal(Product $product){
        $this->productModal = false;
        $this->product_id = $product->id;
        $product= Product::with('image')->find($product->id);
        $this->addProductToSession($product);
    }

    public function closeSupplierModal(Supplier $supplier){
        $this->supplierModal = false;
        $this->purchase->supplier_id = $supplier->id;
        // $product= Product::with('image')->find($product->id);
        // $this->addProductToSession($product);

        $this->dispatchBrowserEvent('salert',[
            'title' =>  'Proveedor ' .  $supplier->name . ' agregado',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);
    }
    
    

    public function validateItems(){
       
        if ($this->items >0) {        
            foreach ($this->items as $key => $item) {
                if ($item['quantity'] == '' || $item['quantity_box'] == '' || $item['price'] == '' || $item['price_box'] == '' || 
                $item['quantity'] <=0 || $item['quantity_box'] <=0 || $item['price'] <=0 || $item['price_box'] <=0) {
                    
                    $this->dispatchBrowserEvent('salert',[
                        'title' =>  'completa campos vacios',
                        'icon' => 'warning',
                        'position' => 'top',
                        'toast' => true,
                        'timer' => 2400,
                    ]);
                    return false;
                } 
            }
        }else{
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'No hay productos en la lista',
                'icon' => 'warning',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
            ]);
            return false;
        }
        return true;
    }

    public function getOrderPurchaseItemRelatedToPurchase($purchase_id){
        
        $listOfOrderPurchaseItem = [];
        $purchase = Purchase::with(['purchaseItems','purchaseItems.orderPurchaseItems'])->find($purchase_id);
       
        foreach ($purchase->purchaseItems as $purchaseItem) {
            foreach ($purchaseItem->orderPurchaseItems as  $orderPurchaseItem) {
                if ($orderPurchaseItem->purchase_item_id == $purchaseItem->id) {
                    $listOfOrderPurchaseItem []= $orderPurchaseItem;
                }
            }
        }

        return $listOfOrderPurchaseItem;

    }

    public function checkStockToRestoreOrder($items, $newItems ){

        if(count($items)==0){
            return true;
        }

        $product = [];
        $existsProduct = false;


        foreach ($items as $item) {
            if (isset($product[$item->product_id])) {
                $product[$item->product_id] += $item->quantity;
            }else{
                $product[$item->product_id] = $item->quantity;
            }
            
            foreach ($newItems as $newItem) {
               if ($item->product_id == $newItem['product_id']) {
                    $existsProduct = true;
                    if ($product[$item->product_id] > $newItem['total_quantity']) {

                        return false;
                    }
               }
            }
        }

        if ($existsProduct) {
            return true;
        }

        return false;
    }

    public function restoreToBeforePurchase($purshase_id){

        $purchase = Purchase::with(['purchaseItems','purchaseItems.orderPurchaseItems'])->find($purshase_id);

        foreach ($purchase->purchaseItems as $purchaseItem) {
            $purchaseItem->product->stock -= $purchaseItem->stock;
            $purchaseItem->product->save();

            $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'product', 'consolelog2' => $purchaseItem->product ]);



            foreach ($purchaseItem->orderPurchaseItems as  $orderPurchaseItem) {
                // if ($orderPurchaseItem->purchase_item_id == $purchaseItem->id) {

                  
                  
                    foreach ($orderPurchaseItem->orderItem->orderPurchaseItems as  $orderItemOrderPurchaseItem) {
                  
                   
                   
                        $orderPurchaseItem->orderItem->order->cost -= $orderItemOrderPurchaseItem->cost;
                        $orderPurchaseItem->orderItem->order->difference -= $orderItemOrderPurchaseItem->difference;
                        $orderPurchaseItem->orderItem->order->save();

                        
                    }
                    
                    // $orderPurchaseItem->orderItem->total_cost -= $orderPurchaseItem->orderItem->total_cost;
                    // $orderPurchaseItem->orderItem->total_difference -= $orderPurchaseItem->orderItem->total_difference;
                    // $orderPurchaseItem->orderItem->cost -= $orderPurchaseItem->orderItem->cost;
                    // $orderPurchaseItem->orderItem->difference -= $orderPurchaseItem->orderItem->difference;
                    // $orderPurchaseItem->orderItem->save();
                    
                // }
            }
        }
      

    }


    
    public function update(){
        $this->validate();
        if (!$this->validateItems()) {
            return false;
        }

         //Antes de eliminar los purchaseItems guarda los orderPurchaseItems relacionados a estos purchaseItems, para luego actualizar el id de los purchaseItems nuevamente creados en los orderPurchaseItems
        $listOfOrderPurchaseItemRelatedToPurchase = $this->getOrderPurchaseItemRelatedToPurchase($this->purchase->id);

        // si hay order items relacionados a estos purchase items, verificar que se volvera a crear el stock necesario para cubrir de lo contrario devuelve false
        if (!$this->checkStockToRestoreOrder($listOfOrderPurchaseItemRelatedToPurchase, $this->items)){
            $this->dispatchBrowserEvent('salert',[
                'text' =>  'hay pedidos relacionados a esta compra, y con esta modificacion no hay suficiente stock para reestablecer el stock de los pedidos',
                'title' =>  'No se actualizó esta compra!',
                'icon' => 'warning',
            ]);
            return false;
        }  

        // restaura stock de productos , y si hay order items relacionados a estos purchase items restaura costo y diferencia de order_items y order
        $this->restoreToBeforePurchase($this->purchase->id);
        


        $this->purchase->user_id_modified = auth()->user()->id;
        $this->purchase->total = $this->total;
        $this->purchase->save();

        // Elimina purchase items y tambien  order purchase item relacionados a esta compra
        $this->purchase->purchaseItems()->delete();

        // SAVE NEW PURCHASE ITEM AND UPDATE MOVEMENT PRODUCTS
        foreach ($this->items as $key => $item) {

            // SAVING NEW PURCHASE ITEM
            $purchase_item = $this->purchase->purchaseItems()->create(
                [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'quantity_box' => $item['quantity_box'],
                    'total_quantity' => $item['total_quantity'],
                    'price' => $item['price'],
                    'price_box' => $item['price_box'],
                    'total_price' => $item['total_price'],
                    'stock' => $item['total_quantity'],
                ]
            );

            // UPDATING PRODUCT STOCK
            $purchase_item->product->stock += $purchase_item->total_quantity;
            $purchase_item->product->save();
            $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'product2', 'consolelog2' => $purchase_item->product ]);

            // $product = Product::find($item['product_id']);
            // $product->stock = $product->stock + $item['total_quantity'];
            // $product->save();            

            $movementProduct = MovementProduct::where('purchase_id', $this->purchase->id)->where('product_id', $purchase_item->product->id)->first();

            // UPDATING MOVEMENT PRODUCTS
            if($movementProduct){
                $movementProduct->purchase_item_id = $purchase_item->id;
                $movementProduct->user_id_modified = auth()->user()->id;
                $movementProduct->save();

            }else{
                // INGRESAR MOVIMIENTO 
                $movementProduct = MovementProduct::create([
                    'product_id' => $purchase_item->product->id,
                    'purchase_item_id' => $purchase_item->id,
                    'purchase_id' => $purchase_item->purchase->id,
                    'type' => 1, //entrada
                    'name_type' => 1, //purchase
                    'date' => date('Y-m-d'),
                    'user_id_created' => auth()->user()->id,
                ]);
            }

           


        }


        // RESTAURANDO STOCK DE PRODUCTOS Y ACTUALIZANDO ORDERPURCHASEITEMS
        if ( count($listOfOrderPurchaseItemRelatedToPurchase) > 0) {
            $orderController = new OrderController();
            foreach ($listOfOrderPurchaseItemRelatedToPurchase as $order_purchase_item) {
                $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'order item 1', 'consolelog2' => $order_purchase_item ]);
                // $orderItem = OrderItem::find($order_item->order_item_id);
                // $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'order item 2', 'consolelog2' => $orderItem ]);
                $orderItem = $orderController->createOrderPurchaseItem($order_purchase_item->order_item_id, $order_purchase_item->quantity);
                $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'product3', 'consolelog2' => $orderItem->product ]);
            }
        }       
    

        if($this->redirect){
            //  redirect()->route('admin.purchases.index')->with('success',   'Compra actualizada!!');        
        }else {
            $this->emit('closePurchaseModal', $this->purchase->id);
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'Compra actualizada!',
                'type' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
            ]);
        }
    }
    
    public function render(){

 

        $this->products = Product::with('image')->get();
        $this->suppliers = Supplier::all();
        return view('livewire.admin.purchases.edit');
    }
}
