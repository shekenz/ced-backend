<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditNullableFieldsFromBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedInteger('width')->nullable()->change();
			$table->unsignedInteger('height')->nullable()->change();
			$table->unsignedInteger('pages')->nullable()->change();
			$table->string('cover')->nullable()->change();
			$table->string('edition')->nullable()->change();
			$table->unsignedFloat('price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            //
        });
    }
}
