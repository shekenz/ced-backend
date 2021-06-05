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
			$table->string('lastname', 64);
            $table->string('firstname', 64);
            $table->string('company', 64)->nullable();
			$table->string('phone');
			$table->string('email');
			$table->string('shipping-address-1', 128);
			$table->string('shipping-address-2', 128)->nullable();
			$table->string('shipping-city', 96);
			$table->string('shipping-postcode');
			$table->string('shipping-country', 2);
			$table->string('invoice-address-1', 128);
			$table->string('invoice-address-2', 128)->nullable();
			$table->string('invoice-city', 96);
			$table->string('invoice-postcode');
			$table->string('invoice-country', 2);
			$table->unsignedInteger('shipping-method-id')->nullable();
			$table->unsignedTinyInteger('status')->default(0);
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
