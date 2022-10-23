<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerReqAddProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_req_add_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->references('id')->on('sellers')->cascadeOnDelete();
            $table->string('indastry_name');
            $table->string('product_name');
            $table->string('product_type');
            $table->string('product_size');
            $table->string('qty_in_unit');
            $table->double('product_price');
            $table->integer('qty_in_stock');
            $table->string('product_image');
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
        Schema::dropIfExists('seller_req_add_products');
    }
}
