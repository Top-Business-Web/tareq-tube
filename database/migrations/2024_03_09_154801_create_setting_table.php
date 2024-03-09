<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->text('logo');
            $table->string('phone');
            $table->unsignedBigInteger('limit_user')->nullable();
            $table->unsignedBigInteger('point_user')->nullable();
            $table->unsignedBigInteger('vat')->nullable();
            $table->text('privacy')->nullable();
            $table->unsignedBigInteger('point_price')->nullable();
            $table->unsignedBigInteger('token_price')->nullable();
            $table->bigInteger('limit_balance');
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
        Schema::dropIfExists('setting');
    }
}
