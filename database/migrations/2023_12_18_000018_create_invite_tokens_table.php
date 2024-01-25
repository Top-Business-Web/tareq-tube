<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteTokensTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'invite_tokens';

    /**
     * Run the migrations.
     * @table invite_tokens
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->text('token')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default('0');

            $table->foreign('user_id', 'fk_invite_tokens_users2_idx')
                ->references('id')->on('users')
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
