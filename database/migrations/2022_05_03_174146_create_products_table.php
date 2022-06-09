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
            $table->string('codigo');
            $table->string('folio')->nullable();
            $table->string('descripcion');
            $table->integer('stock_inicial');
            $table->integer('existencias');
            $table->float('precio_publico');
            $table->float('precio_proveedor');
            $table->string('formato_venta')->nullable();
            $table->string('marca')->nullable();
            
            $table->unsignedBigInteger('proveedore_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->foreign('proveedore_id')->references('id')->on('proveedores')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            
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
