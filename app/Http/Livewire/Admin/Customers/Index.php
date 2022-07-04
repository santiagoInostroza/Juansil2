<?php

namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class Index extends Component{

    use WithPagination;
    
    public $search;
    public $numRows;
    public $columns;
    public $sortField;
    public $sortOrder;
    
    public function mount(){
        $this->search = '';
        $this->numRows = (session()->has('customers.numRows') ) ? session('customers.numRows') : 10;
        $this->columns = (session()->has('customers.columns') ) ? session('customers.columns') : [
            'id' => ['value' =>true, 'name' =>'Id', 'sortable' =>true], 
            'name' => ['value' =>true, 'name' =>'Nombre'],
            'email' => ['value' =>true, 'name' =>'Email'],
            'celphone' => ['value' =>true, 'name' =>'Celular'],
            'alias' => ['value' =>true, 'name' =>'Alias dirección', 'sortable' =>true],
            'address' => ['value' =>true, 'name' =>'Dirección', 'sortable' =>true],
        //     'date' => ['value' =>true, 'name' =>'Fecha','type' =>'date'],
        //     'price' => ['value' =>true, 'name' =>'Precio','type' =>'money'],
        //     'image' => ['value' =>true, 'name' =>'Imagen','type' =>'image'],
        //     'active' => ['value' =>true, 'name' =>'Activo','type' =>'boolean'],
        //    'text' => ['value' =>true, 'name' =>'Texto','type' =>'text'],
            'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        $this->sortField = (session()->has('customers.sortField') ) ? session('customers.sortField') : 'id';
        $this->sortOrder = (session()->has('customers.sortOrder') ) ? session('customers.sortOrder') : 'asc';
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
        session(['customers.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'customers.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'customers.columns' => $this->columns
        ]);
    }
    
    
    
    public function render(){
        $customers = Customer::leftjoin('addresses', function($query){
                $query->on('addresses.customer_id', '=', 'customers.id')
                ->where('addresses.default', '=', 1);
            })
            ->where(function($query){
                $query ->orWhere('customers.name', 'like', '%'.$this->search.'%')
                ->orWhere('customers.email', 'like', '%'.$this->search.'%')
                ->orWhere('customers.celphone', 'like', '%'.$this->search.'%')
                ->orWhere('addresses.name', 'like', '%'.$this->search.'%')
                ->orWhere('addresses.alias', 'like', '%'.$this->search.'%');
            })

            ->select('customers.*', 'addresses.name as address', 'addresses.alias as alias')
            
            ->orderBy($this->sortField, $this->sortOrder)
            ->paginate($this->numRows);
        return view('livewire.admin.customers.index', compact('customers'));
    }
    
    public function delete($id){
        $customer = Customer::find($id);
        $customer->delete();
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'El permiso '. $customer->name . ' ha sido eliminado correctamente',
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
        'customers.sortOrder' => $this->sortOrder
    ]);
    session([
        'customers.sortField' => $this->sortField
    ]);
    }

  
}
