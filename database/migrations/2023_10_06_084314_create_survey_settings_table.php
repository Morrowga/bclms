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
        Schema::create('survey_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->nullable()
            ->references('id')
            ->on('surveys')->onDelete('cascade');
             $table->enum('user_type', [
                'ORG_ADMIN', 'ORG_TEACHER', 'B2C_USER', 'PARENT', 'STUDENT'
            ]);
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
        Schema::dropIfExists('survey_settings');
    }
};
