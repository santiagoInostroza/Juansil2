<?php

namespace App\Http\Livewire\Admin\Brands;

use App\Models\Brand;
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
        $this->numRows = (session()->has('brands.numRows') ) ? session('brands.numRows') : 10;
        $this->columns = (session()->has('brands.columns') ) ? session('brands.columns') : [
            'id' => ['value' =>true, 'name' =>'Id'], 
            'name' => ['value' =>true, 'name' =>'Nombre'],
            'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        $this->sortField = (session()->has('brands.sortField') ) ? session('brands.sortField') : 'id';
        $this->sortOrder = (session()->has('brands.sortOrder') ) ? session('brands.sortOrder') : 'asc';
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
        session(['brands.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'brands.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'brands.columns' => $this->columns
        ]);
    }
    
    
    
    public function render(){
        $brands = Brand::
        where('name', 'like', "%{$this->search}%")
        ->orWhere('name', 'like', "%{$this->search}%")
        ->orderBy($this->sortField, $this->sortOrder)
        ->paginate($this->numRows);
        return view('livewire.admin.brands.index', compact('brands'));
    }
    
    public function delete($id){
        $brand = Brand::find($id);
        $brand->delete();
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'El permiso '. $brand->name . ' ha sido eliminado correctamente',
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
        'brands.sortOrder' => $this->sortOrder
    ]);
    session([
        'brands.sortField' => $this->sortField
    ]);
    }   

    // public function render(){
    //     return view('livewire.admin.brands.index');
    // }
}
