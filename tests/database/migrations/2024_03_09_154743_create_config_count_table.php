<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_count', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['sub', 'view', 'second']);
            $table->unsignedBigInteger('count')->nullable();
            $table->unsignedBigInteger('point')->nullable();
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
        Schema::dropIfExists('config_count');
    }
}
