<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
			$table->string('label', 8);
			$table->float('value');
			$table->boolean('type');
			$table->integer('quantity')->default(0);
			$table->integer('used')->default(0);
            $table->timestamp('created_at');
            $table->date('starts_at');
            $table->date('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
