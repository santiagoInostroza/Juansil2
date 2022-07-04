<?php

namespace App\Http\Livewire\Header;

use Livewire\Component;
use App\Models\Category;

class CategoryList extends Component{
    public $categories;

    protected $listeners = [
        'setCategory',
    ];



    public function render(){

        // SELECCIONA LAS CATEGORIAS QUE NO TIENEN PADRE Y QUE SI TIENEN HIJOS
        $this->categories = Category::whereNull('parent_id')->whereHas('children')->get();

        //  $this->categories = Category::where('parent_id', null)->whereIn('id', function($query){
        //     $query->select('parent_id')->from('categories')->whereNotNull('parent_id');
        // })->get();
        
        return view('livewire.header.category-list');
    }

    public function setCategory($category_id = null){
        $this->emit('setCategory', $category_id);
    }
}
