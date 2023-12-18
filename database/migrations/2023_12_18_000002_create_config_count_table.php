<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigCountTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'config_count';

    /**
     * Run the migrations.
     * @table config_count
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
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
        Schema::dropIfExists($this->tableName);
    }
}
