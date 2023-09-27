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
        Schema::create('survey_scoring_pathways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pathway_id')->references('id')->on('pathways')->onDelete('cascade');
            $table->foreignId('survey_scoring_id')->references('id')->on('survey_scorings')->onDelete('cascade');
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
        Schema::dropIfExists('survey_scoring_pathways');
    }
};
