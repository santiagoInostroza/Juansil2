<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->BigInteger('quantity');
            $table->BigInteger('quantity_box');
            $table->BigInteger('total_quantity');
            
            $table->double('price');
            $table->double('price_box');
            $table->double('total_price');

            $table->double('cost')->nullable();
            $table->double('total_cost')->nullable();

            $table->double('difference')->nullable();
            $table->double('total_difference')->nullable();
            
            // $table->foreignId('purchase_item_id')->constrained('purchases');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
