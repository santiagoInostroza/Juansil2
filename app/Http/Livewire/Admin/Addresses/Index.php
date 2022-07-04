<?php

namespace App\Http\Livewire\Admin\Addresses;

use App\Models\Address;
use Livewire\Component;
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
        $this->numRows = (session()->has('addresses.numRows') ) ? session('addresses.numRows') : 10;
        $this->columns = (session()->has('addresses.columns') ) ? session('addresses.columns') : [
            'id' => ['value' =>true, 'name' =>'Id', 'sortable' =>true], 
            'alias' => ['value' =>true, 'name' =>'Alias', 'sortable' =>true],
            'name' => ['value' =>true, 'name' =>'Dirección', 'sortable' =>true],
            'street' => ['value' =>true, 'name' =>'Calle', 'sortable' =>true],
            'number' => ['value' =>true, 'name' =>'Número', 'sortable' =>true],
            'department' => ['value' =>true, 'name' =>'Departamento', 'sortable' =>true],
            'tower' => ['value' =>true, 'name' =>'Torre', 'sortable' =>true],
            'commune' => ['value' =>true, 'name' =>'Comuna', 'sortable' =>true],
            'telephone' => ['value' =>true, 'name' =>'Teléfono', 'sortable' =>true],
            'comment' => ['value' =>true, 'name' =>'Comentario', 'type' =>'text'],
           
        //     'date' => ['value' =>true, 'name' =>'Fecha','type' =>'date'],
        //     'price' => ['value' =>true, 'name' =>'Precio','type' =>'money'],
        //     'image' => ['value' =>true, 'name' =>'Imagen','type' =>'image'],
        //     'active' => ['value' =>true, 'name' =>'Activo','type' =>'boolean'],
        //    'text' => ['value' =>true, 'name' =>'Texto','type' =>'text'],
            'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        $this->sortField = (session()->has('addresses.sortField') ) ? session('addresses.sortField') : 'id';
        $this->sortOrder = (session()->has('addresses.sortOrder') ) ? session('addresses.sortOrder') : 'asc';
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
        session(['addresses.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'addresses.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'addresses.columns' => $this->columns
        ]);
    }
    
    
    
    public function render(){
        $addresses = Address::
        // where('name', 'like', "%{$this->search}%")
        // ->orWhere('name', 'like', "%{$this->search}%")
        orderBy($this->sortField, $this->sortOrder)
        ->paginate($this->numRows);
        return view('livewire.admin.addresses.index', compact('addresses'));
    }
    
    public function delete($id){
        $address = Address::find($id);
        $address->delete();
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'El permiso '. $address->name . ' ha sido eliminado correctamente',
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
        'addresses.sortOrder' => $this->sortOrder
    ]);
    session([
        'addresses.sortField' => $this->sortField
    ]);
    }
}
