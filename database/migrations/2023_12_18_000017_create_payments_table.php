<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'payments';

    /**
     * Run the migrations.
     * @table payments
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->text('transaction_id')->nullable();
            $table->enum('type', ['package', 'msg']);
            $table->unsignedBigInteger('price');
            $table->unsignedTinyInteger('status')->nullable()->default('0');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();

            $table->foreign('user_id', 'fk_payments_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('model_id', 'fk_payments_packages1_idx')
                ->references('id')->on('packages')
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
