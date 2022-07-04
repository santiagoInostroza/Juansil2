<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller{
    
    
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('can:admin.categories.index')->only('index');
        $this->middleware('can:admin.categories.create')->only('create');
        $this->middleware('can:admin.categories.show')->only('show');
        $this->middleware('can:admin.categories.edit')->only('edit');
        // $this->middleware('subscribed')->except('store');

    }

    public function index(){
        return view('admin.categories.index');
    }

    public function create(){
        return view('admin.categories.create');
    }

    public function show(Category $category){
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category){
        return view('admin.categories.edit', compact('category'));
    }

    public function getCategories(){
        cache()->rememberForever('categories', function(){
           return Category::whereNull('parent_id')->get();
        });
        return cache('categories');
    }

    public function getCategoriesFresh(){
        $value = Cache::pull('categories');
        return $this->getCategories();
    }

    public function getAllCategories(){
        cache()->rememberForever('allCategories', function(){
           return Category::all();
        });
        return cache('allCategories');
    }

    public function getAllCategoriesFresh(){
        $value = Cache::pull('allCategories');
        return $this->getAllCategories();
    }


    

    // public function saveCategory($data){
    //     $this->validate(request(), [
    //         'name' => 'required|string|max:255',
    //         'description' => 'required|string|max:255',
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'parent_id' => 'nullable|integer',
    //         'is_active' => 'required|boolean',
    //     ]);

    //     $category = Category::create([
    //         'name' => request('name'),
    //         'description' => request('description'),
    //         'image' => request('image')->store('categories', 'public'),
    //         'parent_id' => request('parent_id'),
    //         'is_active' => request('is_active'),
    //     ]);

    //     $this->getCategoriesFresh();

    //     return redirect()->route('admin.categories.show', $category);
        
    // }


}
