<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('sku');
            $table->string('name');
            $table->integer('quantity');
            $table->timestamps();
        });

        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sku');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('sku')->references('sku')->on('products');
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
        Schema::dropIfExists('movements');
    }
}
