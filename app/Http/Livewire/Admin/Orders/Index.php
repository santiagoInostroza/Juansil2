<?php

namespace App\Http\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Controllers\Admin\OrderController;

class Index extends Component{

    use WithPagination;
    
public $search = '';
    public $numRows;
    public $columns;
    public $sortField;
    public $sortOrder;
    
    public function mount(){
     
        $this->search = '';
        $this->numRows = (session()->has('orders.numRows') ) ? session('orders.numRows') : 10;
        $this->columns = (session()->has('orders.columns') ) ? session('orders.columns') : [
            'id' => ['value' =>true, 'name' =>'Id', 'sortable' =>true], 
            'customer_name' => ['value' =>true, 'name' =>'Cliente', 'sortable' =>true],
            'address' => ['value' =>true, 'name' =>'Dirección', 'sortable' =>true],
            'date' => ['value' =>true, 'name' =>'Fecha','type' =>'date'],
            'subtotal' => ['value' =>true, 'name' =>'Subtotal','type' =>'money'],
            'delivery_value' => ['value' =>true, 'name' =>'Valor de entrega','type' =>'money'],
            'cost' => ['value' =>true, 'name' =>'Costo','type' =>'money'],
            'total' => ['value' =>true, 'name' =>'Total','type' =>'money'],
            'difference' => ['value' =>true, 'name' =>'Utilidad','type' =>'money'],
            'status' => ['value' =>false, 'name' =>'Estado'],
            'sale_type' => ['value' =>false, 'name' =>'Tipo de venta'],
            'payment_status' => ['value' =>false, 'name' =>'Estado de pago'],
            'payment_account' => ['value' =>false, 'name' =>'Cuenta de pago'],
            'payment_account_comment' => ['value' =>false, 'name' =>'Comentario de cuenta de pago','type' =>'text'],
            'payment_amount' => ['value' =>false, 'name' =>'Monto de pago','type' =>'money'],
            'pending_amount' => ['value' =>false, 'name' =>'Monto pendiente','type' =>'money'],
            'payment_date' => ['value' =>false, 'name' =>'Fecha de pago','type' =>'date'],
            'user_name_paid' => ['value' =>false, 'name' =>'Usuario que recibío pago'],
            'delivery_stage' => ['value' =>false, 'name' =>'Etapa de entrega'],
            'delivery_date' => ['value' =>false, 'name' =>'Fecha de entrega','type' =>'date'],
            'date_delivered' => ['value' =>false, 'name' =>'Fecha entregado','type' =>'date'],
            'users_delivered' => ['value' =>false, 'name' =>'Usuario que entregó'],
            


        //     'image' => ['value' =>true, 'name' =>'Imagen','type' =>'image'],
        //     'active' => ['value' =>true, 'name' =>'Activo','type' =>'boolean'],
        //    'text' => ['value' =>true, 'name' =>'Texto','type' =>'text'],
            'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        $this->sortField = (session()->has('orders.sortField') ) ? session('orders.sortField') : 'id';
        $this->sortOrder = (session()->has('orders.sortOrder') ) ? session('orders.sortOrder') : 'asc';
    }

    
    public function render(){
        $orders = Order::leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
        ->leftjoin('addresses', 'addresses.id', '=', 'orders.address_id')
        ->leftjoin('users', 'users.id', '=', 'orders.user_id_paid')
        ->leftjoin('users as users_delivered', 'users_delivered.id', '=', 'orders.user_id_delivered')
        ->select('orders.*', 'customers.name as customer_name', 'addresses.name as address', 'users.name as user_name_paid', 'users_delivered.name as user_name_delivered')

        // where('name', 'like', "%{$this->search}%")
        // ->orWhere('name', 'like', "%{$this->search}%")
        ->orderBy($this->sortField, $this->sortOrder)
        ->paginate($this->numRows);
        return view('livewire.admin.orders.index', compact('orders'));
    }

    
    public function selectColumns($value){
        switch ($value) {
            case 'all':
                foreach ($this->columns as $name_column => $column ) {
                    $this->columns[$name_column]['value'] = true;
                }
                break;
            case 'none':
                foreach ($this->columns as $name_column => $column ) {
                    $this->columns[$name_column]['value'] = false;
                }
                break;
            case 'switch':
                foreach ($this->columns as $name_column => $column ) {
                    $this->columns[$name_column]['value'] = !$this->columns[$name_column]['value'];
                }
                break;
            
            default:
                
                break;
        }
        session(['orders.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'orders.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'orders.columns' => $this->columns
        ]);
    }
    
    
    
    
    public function delete($id){
        $orderController = new OrderController();
        $order = $orderController->deleteOrder($id);
       
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'El pedido '. $order->name . ' ha sido eliminado correctamente',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);
    }

    public function sortBy($column){
        $this->sortField = $column;
        $this->sortOrder = $this->sortOrder == 'asc' ? 'desc' : 'asc';
        session([
            'orders.sortOrder' => $this->sortOrder
        ]);
        session([
            'orders.sortField' => $this->sortField
        ]);
    }

    
}
