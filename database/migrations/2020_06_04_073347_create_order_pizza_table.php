<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPizzaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pizza', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('number_order');
            $table->unsignedBigInteger('pizzas_id');
            $table->timestamps();
            $table->foreign('pizzas_id')->references('id')->on('pizzas');
            $table->foreign('number_order')->references('number_order')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_pizza');
    }
}
