<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('shop_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->integer('order_amount')->comment('注文金額');
            $table->date('order_date')->comment('注文日');
            $table->date('receive_date')->index()->comment('商品受取日');
            $table->tinyInteger('order_state')->default(1)->comment('注文ステータス:1:未注文, 2:注文中, 3:調理完了, 4:受取完了');
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
        Schema::dropIfExists('orders');
    }
}
