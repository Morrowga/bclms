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
        Schema::create('student_sticker', function (Blueprint $table) {
            $table->foreignId('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreignId('sticker_id')->references('id')->on('stickers')->onDelete('cascade');
            $table->float('y_axis_position', 10,6)->nullable();
            $table->float('x_axis_position', 10,6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_sticker');
    }
};
