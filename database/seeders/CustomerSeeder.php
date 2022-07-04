<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder{

    public function run(){

        $name = "Santiago Inostroza";
        Customer::create([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
        $name = "Patricia Arias";
        Customer::create([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
        $name = "Romina Inostroza";
        Customer::create([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);

    }
}
