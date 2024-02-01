<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'setting';

    /**
     * Run the migrations.
     * @table setting
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->text('logo');
            $table->string('phone');
            $table->unsignedBigInteger('limit_user')->nullable();
            $table->unsignedBigInteger('point_user')->nullable();
            $table->unsignedBigInteger('vat')->nullable();
            $table->text('privacy')->nullable();
            $table->unsignedBigInteger('point_price')->nullable();
            $table->unsignedBigInteger('limit_balance')->nullable();
            $table->unsignedBigInteger('token_price')->nullable();
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
