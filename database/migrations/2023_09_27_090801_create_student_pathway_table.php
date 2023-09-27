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
        Schema::create('student_pathway', function (Blueprint $table) {
            $table->foreignId('student_id')
                ->references('student_id')
                ->on('students')->onDelete('cascade');
            $table->foreignId('pathway_id')
                ->references('id')
                ->on('pathways')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_pathway');
    }
};
