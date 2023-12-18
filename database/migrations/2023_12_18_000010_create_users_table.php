<?php

namespace Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('image')->nullable();
            $table->string('gmail');
            $table->string('password');
            $table->text('google_id');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedTinyInteger('is_admin')->nullable()->default('0');
            $table->unsignedBigInteger('intrest_id')->nullable();
            $table->unsignedBigInteger('points')->nullable()->default('0');
            $table->unsignedBigInteger('limit')->nullable();
            $table->unsignedBigInteger('msg_limit')->nullable();
            $table->unsignedBigInteger('lang_id')->nullable();
            $table->text('youtube_link')->nullable();

            $table->index(["city_id"], 'fk_users_cities1_idx');

            $table->index(["intrest_id"], 'fk_users_intrest1_idx');

            $table->index(["lang_id"], 'fk_users_languages1_idx');


            $table->foreign('city_id', 'fk_users_cities1_idx')
                ->references('id')->on('cities')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('intrest_id', 'fk_users_intrest1_idx')
                ->references('id')->on('intrest')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('lang_id', 'fk_users_languages1_idx')
                ->references('id')->on('languages')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
