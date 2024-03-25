<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleDeviceIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_device_ids', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->text('device_id');
            $table->text('gmail');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            
            $table->unique(['device_id`(500'], 'device_id_unique');
            $table->unique(['gmail`(500'], 'gmail_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_device_ids');
    }
}
