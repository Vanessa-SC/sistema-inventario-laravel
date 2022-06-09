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
        Schema::create('apartados', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->string('cliente');
            $table->float('anticipo');
            $table->float('monto_abonado')->nullable()->default(0);
            $table->enum('estado', ['pendiente', 'liquidado'])->nullable()->default('pendiente');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->dateTime('fecha_limite')->nullable();
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
        Schema::dropIfExists('apartados');
    }
};
