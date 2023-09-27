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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('given_by_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('storybook_id')->references('id')->on('storybooks')->onDelete('cascade');
            $table->enum('stars', [1,2,3,4,5]);
            $table->string('feedback');
            $table->dateTime('given_on');
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
        Schema::dropIfExists('reviews');
    }
};
