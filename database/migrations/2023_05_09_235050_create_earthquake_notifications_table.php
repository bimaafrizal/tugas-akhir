<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earthquake_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('earthquake_id');
            $table->foreignId('user_id');
            $table->integer('distance');
            $table->integer('status_whatsapp')->nullable();
            $table->integer('status_email')->nullable();
            $table->string('user_latitude');
            $table->string('user_longitude');
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
        Schema::dropIfExists('earthquake_notifications');
    }
};
