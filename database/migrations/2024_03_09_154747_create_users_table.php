<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('image')->nullable();
            $table->string('gmail');
            $table->string('password');
            $table->text('google_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedTinyInteger('is_admin')->default(0);
            $table->boolean('is_vip')->default(0);
            $table->unsignedBigInteger('intrest_id')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('points')->default(0);
            $table->unsignedBigInteger('limit')->nullable();
            $table->unsignedBigInteger('msg_limit')->nullable();
            $table->text('invite_token')->nullable();
            $table->text('access_token')->nullable();
            $table->text('youtube_link')->nullable();
            $table->text('youtube_name')->nullable();
            $table->text('youtube_image')->nullable();
            $table->text('channel_name')->nullable();
            $table->timestamps();
            
            $table->foreign('city_id', 'fk_users_cities1_idx')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('intrest_id', 'fk_users_intrest1_idx')->references('id')->on('intrest')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
