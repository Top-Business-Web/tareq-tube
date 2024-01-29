<?php



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
            $table->text('google_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedTinyInteger('is_admin')->nullable()->default('0');
            $table->boolean('is_vip')->default(false);
            $table->unsignedBigInteger('intrest_id')->nullable();
            $table->unsignedBigInteger('points')->nullable()->default('0');
            $table->unsignedBigInteger('limit')->nullable();
            $table->unsignedBigInteger('msg_limit')->nullable();
            $table->text('invite_token')->nullable();
            $table->text('youtube_link')->nullable();
            $table->text('youtube_name')->nullable();
            $table->text('youtube_image')->nullable();
            $table->text('channel_name')->nullable();
            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('intrest_id')
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
