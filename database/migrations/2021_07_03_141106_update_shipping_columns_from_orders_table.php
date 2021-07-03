<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShippingColumnsFromOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->after('country_code', function($table) {
				$table->string('shipping_method', 127)->nullable();
				$table->float('shipping_price')->nullable();
			});
			$table->dropColumn('shipping_option_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
			$table->dropColumn('shipping_method');
			$table->dropColumn('shipping_price');
			$table->after('country_code', function($table) {
				$table->string('shipping_option_id', 127)->nullable();
			});
		});
    }
}
