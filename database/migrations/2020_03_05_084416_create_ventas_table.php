<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigInteger('cliente_id')->unsigned()->index();
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('vendedor_id')->unsigned()->index();
            $table->foreign('vendedor_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['cliente_id', 'vendedor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
