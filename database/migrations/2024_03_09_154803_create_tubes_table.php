<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTubesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tubes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['sub', 'view']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->bigInteger('points')->nullable();
            $table->text('url')->nullable();
            $table->unsignedBigInteger('sub_count')->nullable()->index('fk_tubes_config_count1_idx');
            $table->unsignedBigInteger('second_count')->nullable();
            $table->unsignedBigInteger('view_count')->nullable();
            $table->unsignedBigInteger('target')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
            
            $table->foreign('second_count', 'fk_tubes_config_count2_idx')->references('id')->on('config_count');
            $table->foreign('view_count', 'fk_tubes_config_count3_idx')->references('id')->on('config_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tubes');
    }
}
