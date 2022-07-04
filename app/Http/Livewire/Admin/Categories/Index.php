<?php

namespace App\Http\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category;
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
        $this->numRows = (session()->has('categories.numRows') ) ? session('categories.numRows') : 10;
        $this->columns = (session()->has('categories.columns') ) ? session('categories.columns') : [
            'id' => ['value' =>true, 'name' =>'Id'], 
            'name' => ['value' =>true, 'name' =>'Nombre'],
            'parent_id' => ['value' =>true, 'name' =>'Padre'],
            'children' => ['value' =>true, 'name' =>'Hijos'],
            'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        $this->sortField = (session()->has('categories.sortField') ) ? session('categories.sortField') : 'id';
        $this->sortOrder = (session()->has('categories.sortOrder') ) ? session('categories.sortOrder') : 'asc';
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
        session(['categories.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'categories.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'categories.columns' => $this->columns
        ]);
    }
    
    
    
    public function render(){
        $categories = Category::
        where('name', 'like', "%{$this->search}%")
        ->orWhere('name', 'like', "%{$this->search}%")
        ->orderBy($this->sortField, $this->sortOrder)
        ->paginate($this->numRows);
        return view('livewire.admin.categories.index', compact('categories'));
    }
    
    public function delete($id){
        $category = Category::find($id);
        $category->delete();
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'El permiso '. $category->name . ' ha sido eliminado correctamente',
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
        'categories.sortOrder' => $this->sortOrder
    ]);
    session([
        'categories.sortField' => $this->sortField
    ]);
    }
  
}
