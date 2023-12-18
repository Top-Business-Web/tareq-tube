<?php

namespace Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'msg';

    /**
     * Run the migrations.
     * @table msg
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->text('url');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('lang_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('intrest_id')->nullable();

            $table->index(["lang_id"], 'fk_msg_languages1_idx');

            $table->index(["city_id"], 'fk_msg_cities1_idx');

            $table->index(["intrest_id"], 'fk_msg_intrest1_idx');


            $table->foreign('lang_id', 'fk_msg_languages1_idx')
                ->references('id')->on('languages')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('city_id', 'fk_msg_cities1_idx')
                ->references('id')->on('cities')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('intrest_id', 'fk_msg_intrest1_idx')
                ->references('id')->on('intrest')
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
