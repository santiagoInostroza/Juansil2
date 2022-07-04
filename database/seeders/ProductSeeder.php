<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder{
    public function run(){
        $product =  Product::create([
            'name' => 'Leche entera 1 litro 12 unidades',
            'slug' => 'producto-1',
            'description' => 'Descripcion del producto 1',
            'price' => '10500',
            'product_format_id' =>4 ,
            'quantity_per_format' => 12,
            // 'category_id' => 5,
            'brand_id' => 1,
            'stock' => 0,
        ]);

        // categories
        $product->categories()->attach([5,6]);

        $product->image()->create([
            'url' => 'products/NfNdadOGpITLS2BoStTznsRJqPEX0G9FJmhgWJyv.png',
        ]);


        $product =  Product::create([
            'name' => 'Jugo colun 1 litro',
            'slug' => 'producto-2',
            'description' => 'Descripcion del producto 2',
            'price' => '8000',
            'product_format_id' =>4 ,
            'quantity_per_format' => 12,
            // 'category_id' => 1,
            'brand_id' => 1,
            'stock' => 0,


       
        ]);

        $product->image()->create([
            'url' => 'products/U8HTZyzEJklmATqTlfgwGW4j8e1eCqXN1eMn5PEU.jpg',
        ]);
     
        $product =  Product::create([
            'name' => 'Chocman',
            'slug' => 'producto-3',
            'description' => 'Descripcion del producto 3',
            'price' => '5000',
            'product_format_id' =>4 ,
            'quantity_per_format' => 32,
            // 'category_id' => 1,
            'brand_id' => 1,
            'stock' => 0,


       
        ]);

        $product->image()->create([
            'url' => 'products/N0Gb2388wnhAQJz8zYasJLIUckWnbUQtbkEC3qQi.jpg',
        ]);
     
    }
}
