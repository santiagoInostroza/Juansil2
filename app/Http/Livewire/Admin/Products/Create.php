<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductFormat;
use Livewire\WithFileUploads;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

class Create extends Component{
    use WithFileUploads;

    public $name;
    public $description;
    public $image;
    public $product_format_id;
    public $quantity_per_format;
    public $price;

    public $has_offer;
    public $offer_price;
    public $discount_rate;
    public $fixed_offer;
    public $offer_start_date;
    public $offer_end_date;
    public $whole_sale_price;
    public $is_active_whole_sale_price;
    public $stock_min;
    public $is_active;
    public $category_id;
    public $brand_id;
    public $expiration_date;


   



    public $formats;
    public $categories;
    public $categoriesSelected;

    public $brands;
    
    public $redirect;


    public $categoryModal;
    public $brandModal;

    public $isOpenCategories;
    public $searchCategory;

    protected $listeners = [
        'closeCategoryModal',
        'closeBrandModal',
        'addCategoryToProduct',

    ];


    public function mount($redirect = true){
        $this->is_active_whole_sale_price = false;
        $this->is_active = true;
        $this->categoryModal=false;
        $this->redirect = $redirect;
        $this->fixed_offer = true;
        $this->has_offer = false;
        $this->offer_start_date = date('Y-m-d');
        $this->offer_end_date = date('Y-m-d', strtotime('+7 days'));
        $this->discount_rate = 0;
        $this->categoriesSelected = [];
        $this->isOpenCategories = false;
        $this->searchCategory = '';
        $this->expiration_date = 21;
    }

    public $messages = [
        'categoriesSelected.required' => 'Selecciona por lo menos 1 categoría.',
    ];



    public function rules(){
        $rules ['name'] = 'required|min:3|max:255|unique:products,name,' . $this->id;
        $rules ['description'] = 'nullable|min:3|max:255';
        $rules ['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
        $rules ['product_format_id'] = 'required';
        $rules ['quantity_per_format'] = 'required|numeric';
        $rules ['price'] = 'required|numeric';
        $rules ['has_offer'] = 'required|boolean';


        if($this->has_offer){
            $rules ['offer_price'] = 'required|numeric';
            $rules ['fixed_offer'] = 'required|boolean';
            $rules ['discount_rate'] = 'required|numeric';
        }

        $rules ['categoriesSelected'] = 'required|array';

        if(!$this->fixed_offer){
            $rules ['offer_start_date'] = 'required|date';
            $rules ['offer_end_date'] = 'required|date';
        }

      

        $rules ['is_active_whole_sale_price'] = 'nullable|boolean';
        if ($this->is_active_whole_sale_price) {
            $rules ['whole_sale_price'] = 'required|numeric';
        }


        $rules ['stock_min'] = 'nullable|numeric';
        $rules ['is_active'] = 'nullable|boolean';
        // $rules ['category_id'] = 'required';
        $rules ['brand_id'] = 'required';
        // $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'name', 'consolelog2' => $rules]);    

        $rules ['expiration_date'] = 'required |numeric';


        return $rules;

    }

    public function render(){
        // categories whitout parent
       
        $this->formats = ProductFormat::all();
        $this->brands = Brand::all();
        $this->categories = $this->getAllCategories();

        return view('livewire.admin.products.create');
    }

    public function getAllCategories(){
        $categoryController = new CategoryController();
        // return $categoryController->getAllCategories();
        return $categoryController->getAllCategoriesFresh();
    }

    public function addCategoryToProduct($item,$search = ''){
        if(!isset($this->categoriesSelected[$item['name']])){
            $this->categoriesSelected[$item['name']] = $item;
            $this->dispatchBrowserEvent('salert',[
                'title' =>  ' '. $item['name'] . ' agregado. ',
                'icon' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
            ]);
        }else{
            $this->dispatchBrowserEvent('salert',[
                'title' =>  ' '. $item['name'] . ' ya esta agregado. ',
                'icon' => 'warning',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
            ]);
        }
        $this->isOpenCategories = false;
        $this->searchCategory = $search;
   
    }

    public function removeCategoryFromProduct($name){
        unset($this->categoriesSelected[$name]);
        $this->dispatchBrowserEvent('salert',[
            'title' =>  ' '. $name . ' eliminado. ',
            'icon' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);
    }
    
    public function closeCategoryModal(Category $category){
        $this->categoryModal = false;
        // $this->category_id = $category->id;
        $this->addCategoryToProduct($category,$this->searchCategory);
    }

    
    public function closeBrandModal(Brand $brand){
        $this->brandModal = false;
        $this->brand_id = $brand->id;
    }

    

    public function getProductFormatName(){
        if ($this->product_format_id>0) {
            return 'por ' . $this->formats->where('id', $this->product_format_id)->first()->name;
        } else {
            return"";
        }
    }

    public function updatedProductFormatId(){
        $this->quantity_per_format =($this->getProductFormatName() == "por Unidad")? 1:'';
    }
    

    public function updatedOfferPrice(){
        if ($this->price > $this->offer_price) {
            $this->discount_rate = round(100 - ($this->offer_price / $this->price) *100, 3);
        }
    }

    public function updatedDiscountRate(){

        if ($this->discount_rate > 0) {
            $this->offer_price = round($this->price * (1 - $this->discount_rate / 100));
        }
    }

    public function updatedPrice(){
        if ($this->price > $this->offer_price && $this->discount_rate > 0) {
            $this->discount_rate = round(100 - ($this->offer_price / $this->price) *100, 3);
        }
    }


    public function save(){

        $this->validate();
      
    
        $product = Product::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'brand_id' => $this->brand_id,
            'product_format_id' => $this->product_format_id,
            'quantity_per_format' => $this->quantity_per_format,
            'price' => $this->price,
            'has_offer' => $this->has_offer,
            'offer_price' => $this->offer_price,
            'discount_rate' => $this->discount_rate,
            'fixed_offer' => $this->fixed_offer,
            'offer_start_date' => $this->offer_start_date,
            'offer_end_date' => $this->offer_end_date,
            'whole_sale_price' => $this->whole_sale_price,
            'is_active_whole_sale_price' => $this->is_active_whole_sale_price,
            'stock_min' => $this->stock_min,
            'is_active' => $this->is_active,
            'stock' => 0,
            'expiration_date' => $this->expiration_date,

        ]);

        foreach ($this->categoriesSelected as $category) {
            $product->categories()->attach($category['id']);
        }
        
        $url = $this->image->store('products');

        $product->image()->create([
            'url' => $url,
        ]);

        if($this->redirect){
            redirect()->route('admin.products.index')->with('success',  $product->name . ' creado correctamente');        
        }else{
            $this->emit('closeProductModal', $product->id);
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'El producto '. $product->name . ' ha sido creado correctamente',
                'type' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
            ]);
        }    
    
    }  


}
