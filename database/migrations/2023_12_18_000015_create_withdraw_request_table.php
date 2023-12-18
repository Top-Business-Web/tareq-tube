<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawRequestTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'withdraw_request';

    /**
     * Run the migrations.
     * @table withdraw_request
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('phone', 250)->nullable();
            $table->enum('status', ['pending', 'progress', 'done'])->nullable();
            $table->unsignedBigInteger('price')->nullable();

            $table->index(["user_id"], 'fk_withdraw_request_users1_idx');


            $table->foreign('user_id', 'fk_withdraw_request_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

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
