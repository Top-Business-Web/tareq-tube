<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoponsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copons_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('fk_copons_user_users1_idx');
            $table->unsignedBigInteger('copon_id')->nullable()->index('fk_copons_user_copons1_idx');
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
        Schema::dropIfExists('copons_user');
    }
}
