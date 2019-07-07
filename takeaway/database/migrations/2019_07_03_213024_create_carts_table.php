<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('session_id')->index();
            $table->unsignedBigInteger('menu_id');
            $table->string('title');
            $table->decimal('base_price', 8, 2);
            $table->decimal('price', 8, 2);
            $table->unsignedTinyInteger('quantity');
            $table->text('options'); // array

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
        Schema::dropIfExists('carts');
    }
}
