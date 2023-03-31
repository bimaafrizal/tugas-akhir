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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle');
            $table->string('image_title')->nullable();
            $table->string('image_title2')->nullable();
            $table->string('logo')->nullable();
            $table->string('title_about1');
            $table->string('about1');
            $table->string('image1')->nullable();
            $table->string('title_about2');
            $table->string('about2');
            $table->string('image2')->nullable();
            $table->string('footer');
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
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
        Schema::dropIfExists('landing_pages');
    }
};