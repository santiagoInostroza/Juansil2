<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        ProductFormat::create([
            'name' => 'Unidad',
            'slug' => 'unidad',
        ]);

        ProductFormat::create([
            'name' => 'Pack',
            'slug' => 'pack',
        ]);
        ProductFormat::create([
            'name' => 'Display',
            'slug' => 'display',
        ]);

        ProductFormat::create([
            'name' => 'Caja',
            'slug' => 'caja',
        ]);

      
        
    }
}
