<?php

namespace App\Http\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category;

class Edit extends Component{
    public $category;
    public $categories;
    
    public function mount($category){
        $this->category = $category;
        $this->categories = Category::all();
    }
    
    protected $rules = [
        'category.name' => 'required|unique:categories,name',
        'category.parent_id' => 'required',
    ];
    
    public function update(){
        $this->validate();
        $this->category->save();
        redirect()->route('admin.categories.index')->with('success', $this->category->name . ' actualizado correctamente');
}   

    public function render(){
        return view('livewire.admin.categories.edit');
    }
}
