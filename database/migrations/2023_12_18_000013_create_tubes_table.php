<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTubesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'tubes';

    /**
     * Run the migrations.
     * @table tubes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->enum('type', ['sub', 'view']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->bigInteger('points')->nullable();
            $table->text('url')->nullable();
            $table->unsignedBigInteger('sub_count')->nullable();
            $table->unsignedBigInteger('second_count')->nullable();
            $table->unsignedBigInteger('view_count')->nullable();
            $table->unsignedBigInteger('target')->nullable();
            $table->tinyInteger('status')->nullable()->default('0');

            $table->foreign('sub_count', 'fk_tubes_config_count1_idx')
                ->references('id')->on('config_count')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('second_count', 'fk_tubes_config_count2_idx')
                ->references('id')->on('config_count')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('view_count', 'fk_tubes_config_count3_idx')
                ->references('id')->on('config_count')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_tubes_users1_idx')
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
