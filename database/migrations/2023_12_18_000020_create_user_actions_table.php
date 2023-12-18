<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'user_actions';

    /**
     * Run the migrations.
     * @table user_actions
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('tube_id')->nullable();
            $table->enum('type', ['view', 'sub']);
            $table->tinyInteger('status')->default('0');
            $table->unsignedBigInteger('potints')->nullable();

            $table->index(["user_id"], 'fk_user_actions_users1_idx');

            $table->index(["tube_id"], 'fk_user_actions_tubes1_idx');


            $table->foreign('user_id', 'fk_user_actions_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tube_id', 'fk_user_actions_tubes1_idx')
                ->references('id')->on('tubes')
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
