<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('shop_id')->index();
            $table->unsignedBigInteger('category_id')->default(0);
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('menu_order')->default(0);
            $table->decimal('price', 8, 2);
            $table->text('main_option'); // option is array of {name, price}
            $table->text('side_options'); // options is array of option

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
        Schema::dropIfExists('menus');
    }
}
