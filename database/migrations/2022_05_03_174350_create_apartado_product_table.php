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
        Schema::create('apartado_product', function (Blueprint $table) {
            $table->float('precio');
            $table->unsignedBigInteger('apartado_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('apartado_id')->references('id')->on('apartados')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartado_product');
    }
};
