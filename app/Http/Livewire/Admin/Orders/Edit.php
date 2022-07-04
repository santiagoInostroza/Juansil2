<?php

namespace App\Http\Livewire\Admin\Orders;

use App\Models\Address;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Http\Controllers\Admin\OrderController;

class Edit extends Component{

    public $order;

    public $redirect;
    
    public $products;
    public $customers;
    public $addresses;
    public $openComment;
    
    public $productModal;
    public $customerModal;
    public $addressModal;
    public $showPaymentAccount;
    
    public $product_id;
    public $address_id;
    public $defaultAddress;
    
    public $customer;
    
    public $customer_id;
    public $date;
    public $subtotal;

    public $status;
    public $sale_type;


    // PAGO
    public $payment_amount;
    public $payment_status;
    public $payment_account;
    public $payment_account_comment;



    // DELIVERY
    public $delivery;
    public $delivery_value;
    public $delivery_date;
    public $delivery_stage;

    public $comment;

    public $items;


    protected $listeners = [
        'closeProductModal',
        'addItemToOrder',
        'closeCustomerModal',
        'closeAddressModal',
    ];

    public function rules(){

        $ruleValidators = [];        
        $ruleValidators['customer_id'] = 'required';
        $ruleValidators['date'] = 'required';
        $ruleValidators['payment_status'] = 'required';
        $ruleValidators['payment_account_comment'] = 'nullable';

        if ($this->payment_status != 0) { 

            $ruleValidators['payment_account'] = 'required';

            if ($this->payment_status == 1) {
                $ruleValidators['payment_amount'] = 'required';
            }
           
        }       

        if ($this->delivery) {

            $ruleValidators['delivery_value'] = 'required';
            $ruleValidators['delivery_date'] = 'required';
            $ruleValidators['address_id'] = 'required';
          
        }

        $ruleValidators['comment'] = 'nullable';

        return $ruleValidators;


    }

    public function mount($redirect = true){
        $this->redirect = $redirect;
        $this->productModal = false;
        $this->customerModal = false;
        $this->addressModal = false;
        $this->openComment = ($this->order->comment) ? true: false;
        // $this->showPaymentAccount = (session()->has('editOrder.showPaymentAccount')) ? session()->get('editOrder.showPaymentAccount') : false;
        
        $this->customer_id = $this->order->customer_id;
        $this->customer = ($this->customer_id)  ? Customer::find($this->customer_id) : null;
       
        $this->address_id = $this->defaultAddress = $this->order->address_id;
        $this->date = date('Y-m-d', strtotime($this->order->date)) . 'T' . date('H:i', strtotime($this->order->date));

        $this->subtotal = $this->order->subtotal;

        $this->status = $this->order->status;
        $this->sale_type = $this->order->sale_type;

        $this->payment_status = $this->order->payment_status;
        $this->payment_amount = $this->order->payment_amount;
        $this->payment_account = $this->order->payment_account;
        $this->payment_account_comment = $this->order->payment_account_comment;

        $this->delivery =   $this->order->delivery;
        $this->delivery_value = $this->order->delivery_value;
        $this->delivery_date = $this->order->delivery_date;
        $this->delivery_stage = $this->order->delivery_stage;


        $this->comment = $this->order->comment;

        $this->user_id_modified = auth()->user()->id ;

        $this->items = [];
        
        foreach ($this->order->orderItems as $item) {
            $this->items['items'][$item->product->id] =    [ 
                'product_id' => $item->product->id,
                'name' => $item->product->name,
                'image_url' => $item->product->image->url,
                'stock' => $item->product->stock,
                'quantity' => $item->quantity,
                'quantity_box' => $item->quantity_box,
                'total_quantity' => $item->total_quantity,
                'price' => $item->price  ,
                'price_box' => $item->price_box,
                'total_price' => $item->total_price,
                'total_quantity_old' => $item->total_quantity,
            ];
        }

        $this->items['total'] = $this->order->subtotal;

    }

    // public function updatedPaymentAccount(){
    //     session()->put('editOrder.payment_account', $this->payment_account);
    // }  
    public function updatedPaymentStatus(){
        // session()->put('editOrder.payment_status', $this->payment_status);
        if($this->payment_status != 0){
            $this->showPaymentAccount = true;
        }else{
            $this->showPaymentAccount = false;
        }
        // session()->put('editOrder.showPaymentAccount', $this->showPaymentAccount);
    }  

    public function updatedCustomerId(){
        // save customer id in session
        // session()->put('editOrder.customer_id', $this->customer_id);

        if($this->customer_id){
            $this->customer = Customer::find($this->customer_id);
            $defaultAddress = Address::where('customer_id', $this->customer_id)->where('default', 1)->first();
            $this->address_id = ($defaultAddress) ? $defaultAddress->id : null;
        }else{
            $this->customer = null;
            $this->delivery = 0;
        }


        
       
    }

    public function updatedDelivery(){

        // session()->put('editOrder.delivery', $this->delivery);

        $this->delivery_value = 1000;
        if(!$this->delivery){
            $this->delivery_value = 0;
        }
        // session()->put('editOrder.delivery_value', $this->delivery_value);
       
    }

    // public function updatedDeliveryStage(){
    //     session()->put('editOrder.delivery_stage', $this->delivery_stage);       
    // }

    // public function updatedDeliveryDate(){
    //     session()->put('editOrder.delivery_date', $this->delivery_date);
    // }

    // public function updatedDeliveryValue(){
    //     session()->put('editOrder.delivery_value', $this->delivery_value);
    // }

    // public function updatedAddressId(){
    //     session()->put('editOrder.address_id', $this->address_id);
    // }

    // public function updatedOpenComment(){
    //     session()->put('editOrder.openComment', $this->openComment);
    // }

    // public function updatedComment(){
    //     session()->put('editOrder.comment', $this->comment);
    // }

    // public function updatedPaymentAccountComment(){
    //     session()->put('editOrder.payment_account_comment', $this->payment_account_comment);
    // }

 




    public function addItemToOrder(Product $product){
        
        $orderController = new OrderController();
        $response = $orderController->addItemToEditOrder($product, $this->items);
        
        if($response){
            $this->items = $response;
            $this->dispatchBrowserEvent('salert',[
                'title' =>  $product->name . ' agregado a la lista',
                'icon' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 3400,
            ]);
        }else{
            $this->dispatchBrowserEvent('salert',[
                'title' =>  $product->name . ' ya está en lista',
                'icon' => 'warning',
                'position' => 'top',
                'toast' => true,
                'timer' => 3400,
            ]);
        }
        
    }

    public function removeItemFromOrder(Product $product){
        $orderController = new OrderController();   
       $this->items = $orderController->removeItemFromEditOrder($product, $this->items);
        

        $this->dispatchBrowserEvent('salert',[
            'title' =>  $product->name . ' eliminado de la lista',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
            ]);
    }

    public function setItemFromOrder($product_id,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price){
        $orderController = new OrderController();
        $this->items =  $orderController->setItemFromEditOrder($product_id,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price,$this->items);
    }

     
    
    public function closeCustomerModal(Customer $customer){
        $this->customerModal = false;
        $this->customer_id = $customer->id;
        $this->customer = Customer::find($this->customer_id);
        $this->updatedCustomerId();
   }    

    public function closeAddressModal(Address $address){
        $this->addressModal = false;
        
        $this->addresses = Address::where('customer_id',$this->customer_id)->get();
        $this->address_id =  $address->id;
    }    

    public function validateItems(){
       
        if (isset($this->items['items']) && count($this->items['items']) >0) {        
            foreach ($this->items['items'] as $key => $item) {
                if ($item['quantity'] == '' || $item['quantity_box'] == '' || $item['price'] == '' || $item['price_box'] == '' || 
                $item['quantity'] <=0 || $item['quantity_box'] <=0 || $item['price'] <=0 || $item['price_box'] <=0) {
                    
                    $this->dispatchBrowserEvent('salert',[
                        'title' =>  'completa campos vacios',
                        'icon' => 'warning',
                        'position' => 'top',
                        'toast' => true,
                        'timer' => 3500,
                    ]);

                    return false;
                } 

            //    VALIDAR STOCK ANTERS DE CONTINUAR
            $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'name', 'consolelog2' => $item]);
                $product = Product::find($item['product_id']);
                session()->put('editOrder.items.'.$key.'.stock', $product->stock);
                if( $product->stock  <  ($item['total_quantity'] - $item['total_quantity_old'] )){
                    $this->dispatchBrowserEvent('salert',[
                        'title' =>  'stock insuficiente de ' . $product->name,
                        'icon' => 'warning',
                        'position' => 'top',
                        'toast' => true,
                        'timer' => 3500,
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

    public function update(){
        $this->validate();

        if (!$this->validateItems()) {
            return false;
        }
        $this->status = 0; //REVISAR    

        $orderData=[
            'customer_id' => $this->customer_id,
            'address_id' => $this->address_id,

            'date' => $this->date,

            'subtotal' => $this->items['total'],

            'status' => $this->status,
            'sale_type' => 0,

            'payment_status' => $this->payment_status,
            'payment_account' => $this->payment_account,
            'payment_account_comment' => $this->payment_account_comment,

            'delivery' => $this->delivery,
            'delivery_stage' => $this->delivery_stage,
            'delivery_value' => $this->delivery_value,
            'delivery_date' => $this->delivery_date,

            // 'is_invoice_delivered' => $this->is_invoice_delivered,
            // 'invoice_delivered_date' => $this->invoice_delivered_date,
            // 'user_id_invoice_delivered' => $this->user_id_invoice_delivered,

            'comment' => $this->comment,
        
        ];

        $items = $this->items['items'];

        $orderController = new OrderController();
        $order = $orderController->update($this->order->id, $orderData,$items );

      
    

        if($this->redirect){
            redirect()->route('admin.orders.index')->with('success', 'pedido' .  $order->id . ' actualizado correctamente!');        
        }else {
            $this->emit('closeOrderModal', $order->id);
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'Pedido '. $order->id . ' actualizado correctamente!',
                'type' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
            ]);
        }
    }


    public function render(){

        $this->products = Product::all();
        $this->customers = Customer::leftjoin('addresses','addresses.customer_id','customers.id')
        ->select('customers.*','addresses.id as address_id','addresses.name as address')
        ->orderBy('customers.name','asc')
        ->get()->map(function($customer){
            return [
                'id' => $customer->id,
                'name' => $customer->name . ' - ' . $customer->address . '',
                'address' => $customer->address,
                'address_id' => $customer->address_id,
            ];
        });

        $this->addresses = Address::where('customer_id', $this->customer_id)->get();

        return view('livewire.admin.orders.edit');
    }
}
