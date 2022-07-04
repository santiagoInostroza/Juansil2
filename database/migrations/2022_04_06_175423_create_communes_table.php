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
        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('has_delivery_monday')->default(false);
            $table->integer('delivery_price_monday')->default(0);
            $table->boolean('has_delivery_tuesday')->default(false);
            $table->integer('delivery_price_tuesday')->default(0);
            $table->boolean('has_delivery_wednesday')->default(false);
            $table->integer('delivery_price_wednesday')->default(0);
            $table->boolean('has_delivery_thursday')->default(false);
            $table->integer('delivery_price_thursday')->default(0);
            $table->boolean('has_delivery_friday')->default(false);
            $table->integer('delivery_price_friday')->default(0);
            $table->boolean('has_delivery_saturday')->default(false);
            $table->integer('delivery_price_saturday')->default(0);
            $table->boolean('has_delivery_sunday')->default(false);
            $table->integer('delivery_price_sunday')->default(0);
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
        Schema::dropIfExists('communes');
    }
};
