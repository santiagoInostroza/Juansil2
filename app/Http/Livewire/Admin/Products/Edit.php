<?php

namespace App\Http\Livewire\Admin\Products;

use App\Http\Controllers\Admin\CategoryController;
use App\Models\Brand;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductFormat;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Edit extends Component{
    use WithFileUploads;
    public $product;


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

    public $messages = [
        'categoriesSelected.required' => 'Selecciona por lo menos 1 categoría.',
    ];



    public function rules(){
        $rules ['name'] = ['required',Rule::unique('products')->ignore($this->product)];
        $rules ['product.description'] = 'nullable|min:3|max:255';
        $rules ['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
        $rules ['product.product_format_id'] = 'required';
        $rules ['product.quantity_per_format'] = 'required|numeric';
        $rules ['product.price'] = 'required|numeric';
        $rules ['product.has_offer'] = 'required|boolean';


        if($this->has_offer){
            $rules ['product.offer_price'] = 'required|numeric';
            $rules ['product.fixed_offer'] = 'required|boolean';
            $rules ['product.discount_rate'] = 'required|numeric';
        }

        $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'name', 'consolelog2' => gettype($this->categoriesSelected)]);
        $rules ['categoriesSelected'] = 'required|array';

        if($this->fixed_offer){
            $rules ['product.offer_start_date'] = 'required|date';
            $rules ['product.offer_end_date'] = 'required|date';
        }

      

        $rules ['product.is_active_whole_sale_price'] = 'nullable|boolean';
        if ($this->is_active_whole_sale_price) {
            $rules ['product.whole_sale_price'] = 'required|numeric';
        }


        $rules ['product.stock_min'] = 'nullable|numeric';
        $rules ['product.is_active'] = 'nullable|boolean';
        // $rules ['category_id'] = 'required';
        $rules ['product.brand_id'] = 'required';
        // $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'name', 'consolelog2' => $rules]);    

        $rules ['product.expiration_notice_days'] = 'required |numeric';
        $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'name', 'consolelog2' => $rules]);

        return $rules;

    }

    public function mount($product){

        $this->product = $product;
        $this->name = $product->name;
        
        if ($product->categories->count() > 0) {
            foreach ($product->categories as $key => $category) {
                $this->categoriesSelected[$category->name] = ['id'=>$category->id,'name'=>$category->name];
            }
        }else{
            $this->categoriesSelected = [];
        }
       

    }

    public function render(){
        $this->formats = ProductFormat::all();
        $this->brands = Brand::all();
        $this->categories = $this->getAllCategories();
        return view('livewire.admin.products.edit');
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
        $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'name', 'consolelog2' => $name]);
        $this->dispatchBrowserEvent('consolelog',[ 'consolelog' => 'categoriesSelected', 'consolelog2' => $this->categoriesSelected]);
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
   
    
    public function update(){
        $this->validate();
       
        $this->product->name = $this->name;
        $this->product->slug = Str::slug($this->product->name);
        $this->product->save();

        $categoriesIds= [];
        foreach ($this->categoriesSelected as $key => $category) {
           $categoriesIds[] =  $category['id'];
        }

        $this->product->categories()->sync($categoriesIds);


        if ($this->image) {
            Storage::delete($this->product->image->url);
           
            $this->product->image->url = $this->image->store('products');
            $this->product->image->save();
            $this->product->save();
            
        }       
       


        redirect()->route('admin.products.edit',$this->product->slug)->with('success', $this->product->name . ' actualizado correctamente');
    }   

   
}
