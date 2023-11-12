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
            $table->string('orderid');
            $table->string('userid');
            $table->string('name');
            $table->string('price');
            $table->string('phone');
            $table->string('products_desc');
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pin')->nullable();
            $table->string('status')->default(1)->comment('1-new, 2-transit, 3-ofd, 4-deliver, 5-return, 6-lost, 7-cancel');
            $table->string('return_status')->nullable();
            $table->string('shipingcost')->nullable();
            $table->string('packagetype')->nullable();
            $table->string('weight')->nullable();
            $table->string('trackingNo')->nullable();
            $table->string('paymenttype')->default('COD');
            $table->string('date')->nullable();
            $table->string('manifested_at')->nullable();
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
