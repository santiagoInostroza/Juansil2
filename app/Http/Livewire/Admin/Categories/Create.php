<?php

namespace App\Http\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

class Create extends Component{

    public $name;
    public $parent_id;
    public $categories;
    public $redirect;

    public function mount($redirect=true){
        
        $this->redirect = $redirect;
    }
    
    public function save(){
        $this->validate([
            'name' => 'required|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
    
        $category = Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'parent_id' => $this->parent_id,
        ]);
    
        if ($this->redirect) {
            redirect()->route('admin.categories.index')->with('success',  $category->name . ' creado correctamente');        
        } else {
           $this->emit('closeCategoryModal',$category->id);
           $this->dispatchBrowserEvent('salert',[
            'title' =>  'El permiso '. $category->name . ' ha sido creado correctamente',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
            ]);
        }
        
    
    
    }

    public function render(){
        $this->categories = Category::all();
        return view('livewire.admin.categories.create');
    }
}
