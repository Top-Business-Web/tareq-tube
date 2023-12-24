<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'payment_transactions';

    /**
     * Run the migrations.
     * @table payment_transactions
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default('0');

            $table->foreign('payment_id', 'fk_payment_transactions_payments1_idx')
                ->references('id')->on('payments')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_payment_transactions_users1_idx')
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
