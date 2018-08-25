<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwapPairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swap_pairs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('active_id');
            $table->integer('active_ratio');
            $table->integer('dead_id');
            $table->integer('dead_ratio');
            $table->string('active_fee_address');
            $table->string('active_address');
            $table->string('dead_address');
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
        Schema::dropIfExists('swap_pairs');
    }
}
