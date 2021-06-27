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

			$table->string('transaction_id', 17);
			$table->string('payer_id', 13)->nullable();

			$table->string('surname', 140)->nullable();
			$table->string('given_name', 140)->nullable();
			$table->string('full_name', 300)->nullable();
			$table->string('phone', 14)->nullable();
			$table->string('email_address', 254)->nullable();

			$table->string('address_line_1', 300)->nullable();
			$table->string('address_line_2', 300)->nullable();
			$table->string('admin_area_2', 120)->nullable(); // City
			$table->string('admin_area_1', 300)->nullable(); // Region
			$table->string('postal_code', 60)->nullable();
			$table->string('country_code', 2)->nullable();

			$table->string('shipping_option_id', 127)->nullable();
			$table->string('status', 255);

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
