<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
         
            // create and edit shop
            $table->string('shop_name')->unique(); // subdomain
            $table->string('shop_domain')->unique(); // full domain, hide when create
            $table->boolean('is_open'); // hide when create
            $table->date('created_on'); // hide when create
            $table->date('expire_on');

            // shop settings
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('shop_logo')->nullable();
            $table->string('addr_1')->nullable();
            $table->string('addr_2')->nullable();
            $table->string('addr_3')->nullable();
            $table->string('addr_town')->nullable();
            $table->text('opening_hours')->nullable(); // array of {date,from,to}
            $table->text('delivery_areas')->nullable();
         
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
        Schema::dropIfExists('shops');
    }
}
