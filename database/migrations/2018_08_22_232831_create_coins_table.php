<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ticker');
            $table->string('algorithm');
            $table->string('generation_type');
            $table->string('host');
            $table->integer('port');
            $table->string('rpc_user');
            $table->string('rpc_password');
            $table->boolean('active_project');
            $table->string('exchanges');
            $table->string('supported_swaps');
            $table->double('fee');
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
        Schema::dropIfExists('coins');
    }
}
