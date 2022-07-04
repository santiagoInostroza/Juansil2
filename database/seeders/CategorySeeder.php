<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $categories = [
            'Lacteos',
            'Colaciones',
            'Jugos y Bebidas',
            // 'Abarrotes',
            // 'Frutas',
            // 'Verduras',
            // 'Limpieza',
            // 'Higiene',
            // 'Bazar',
            // 'Cuidado Personal',
            // 'Cuidado de la Mascota',
            // 'Cuidado del Bebe',
            // 'Cuidado del Adulto',
            'Otros',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
        
      
        $name = 'Leches blancas';
        Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => 1,
        ]);
      
        $name = 'Leches de sabores';
        Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => 1,
        ]);

        $name = 'Leches sin lactosa';
        Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => 1,
        ]);
    
        $name = 'Leches bombillin';
        Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => 1,
        ]);

        $name = 'Galletas';
        Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => 2,
        ]);

        $name = 'Bizcochos';
        Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => 2,
        ]);

        $name = 'bombillin';
        Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => 2,
        ]);

        $name = 'Jugos sabores';
        Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => 3,
        ]);


    }
}
