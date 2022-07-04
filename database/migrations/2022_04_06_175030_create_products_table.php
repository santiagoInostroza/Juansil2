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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();
            // $table->string('image')->nullable();
            $table->foreignId('product_format_id')->constrained;
            $table->integer('quantity_per_format');
            $table->double('price')->nullable();
            // $table->double('comparison_price')->nullable();
            $table->boolean('has_offer')->default(false);
            $table->double('offer_price')->nullable()->default(0);
            $table->double('discount rate')->nullable()->default(0);
            $table->boolean('fixed_offer')->default(true);
            $table->date('offer_start_date')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->double('whole_sale_price')->nullable();
            $table->boolean('is_active_whole_sale_price')->default(true);
            $table->bigInteger('stock')->nullable();
            $table->bigInteger('stock_min')->nullable();
            $table->boolean('is_active')->default(true);
            $table->tinyInteger('expiration_notice_days')->default(21);
            // $table->unsignedBigInteger('category_id')->constrained;
            $table->unsignedBigInteger('brand_id')->constrained;


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
        Schema::dropIfExists('products');
    }
};
