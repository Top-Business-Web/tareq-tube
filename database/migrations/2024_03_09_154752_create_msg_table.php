<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->text('content')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('intrest_id')->nullable();
            $table->timestamps();
            
            $table->foreign('city_id', 'fk_msg_cities1_idx')->references('id')->on('cities');
            $table->foreign('intrest_id', 'fk_msg_intrest1_idx')->references('id')->on('intrest');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msg');
    }
}
