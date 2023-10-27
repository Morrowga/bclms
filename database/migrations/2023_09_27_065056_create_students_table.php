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
        Schema::create('students', function (Blueprint $table) {
            $table->id("student_id");
            $table->foreignId('user_id')->nullable()
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreignId('organisation_id')->nullable()
                ->references('id')
                ->on('organisations')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()
                ->references('parent_id')
                ->on('parents')->onDelete('cascade');
            $table->foreignId('device_id')->nullable()
                ->references('id')
                ->on('devices')->onDelete('cascade');
            $table->string('gender');
            $table->date('dob')->nullable();
            $table->string('education_level');
            $table->integer('num_gold_coins')->default(0);
            $table->integer('num_silver_coins')->default(0);
            $table->integer('student_code')->nullable();
            $table->float('total_time_spent')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
