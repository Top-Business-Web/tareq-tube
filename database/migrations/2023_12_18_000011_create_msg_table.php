<?php



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
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('intrest_id')->nullable();

            $table->foreign('city_id', 'fk_msg_cities1_idx')
                ->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('intrest_id', 'fk_msg_intrest1_idx')
                ->references('id')->on('intrest')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
