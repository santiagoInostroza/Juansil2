<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Product;
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
        $this->numRows = (session()->has('products.numRows') ) ? session('products.numRows') : 10;
        $this->columns = (session()->has('products.columns') ) ? session('products.columns') : [
            'id' => ['value' =>true, 'name' =>'Id'], 
            'name' => ['value' =>true, 'name' =>'Nombre'],
            'description' => ['value' =>true, 'name' =>'Descripción'],
            'image' => ['value' =>true, 'name' =>'Imagen', 'sortable' =>false],
            'product_format_id' => ['value' =>true, 'name' =>'Formato'],
            'quantity_per_format' => ['value' =>true, 'name' =>'CantXForm.'],
            'price' => ['value' =>true, 'name' =>'Precio'],
            'stock' => ['value' =>true, 'name' =>'Stock'],
           

            'offer_price' => ['value' =>false, 'name' =>'Precio oferta'],
            'start_offer_price' => ['value' =>false, 'name' =>'Inicio oferta'],
            'end_offer_price' => ['value' =>false, 'name' =>'Fin oferta'],
            'special_price' => ['value' =>true, 'name' =>'Precio especial'],
            'is_active_special_price' => ['value' =>true, 'name' =>'Especial activo'],
            'stock_min' => ['value' =>true, 'name' =>'Stock mínimo'],
            'is_active' => ['value' =>true, 'name' =>'Estado'],
            'categories' => ['value' =>true, 'name' =>'Categorías', 'sortable' =>false],
            'brand_id' => ['value' =>true, 'name' =>'Marca'],
            'created_at' => ['value' =>false, 'name' =>'Creado'],
            'updated_at' => ['value' =>false, 'name' =>'Actualizado'],

            'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        // $this->sortField ='id';
        $this->sortField = (session()->has('products.sortField') ) ? session('products.sortField') : 'id';
        $this->sortOrder = (session()->has('products.sortOrder') ) ? session('products.sortOrder') : 'asc';
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
        session(['products.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'products.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'products.columns' => $this->columns
        ]);
    }
    
    
    
    public function render(){
        $products = Product:: with(['brand', 'categories', 'image'])
            ->where('products.name', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortField, $this->sortOrder)
            ->paginate($this->numRows);
       
        return view('livewire.admin.products.index', compact('products'));
    }
    
    public function delete($id){
        $product = Product::find($id);
        $product->delete();
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'El permiso '. $product->name . ' ha sido eliminado correctamente',
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
        'products.sortOrder' => $this->sortOrder
    ]);
    session([
        'products.sortField' => $this->sortField
    ]);
    }

    // public function render(){

    //     return view('livewire.admin.products.index');
    // }
}
