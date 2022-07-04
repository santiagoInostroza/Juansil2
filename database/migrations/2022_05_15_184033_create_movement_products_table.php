<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
 
    public function up(){
        Schema::create('movement_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('purchase_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('purchase_item_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('order_item_id')->nullable()->constrained()->onDelete('set null');
            $table->tinyInteger('type'); // 1: entrada, 2: salida
            $table->tinyInteger('name_type'); // 1: Purchase, 2: Sale, 3: devolucion 4:  merma 5: ajuste
            $table->dateTime('date');
            // $table->bigInteger('stock');
            $table->foreignId('user_id_created')->constrained('users');
            $table->foreignId('user_id_modified')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    

    public function down(){
        Schema::dropIfExists('movement_products');
    }
};
