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
        Schema::create('pathway_disability_types', function (Blueprint $table) {
            $table->foreignId('pathway_id')
                ->references('id')
                ->on('pathways')->onDelete('cascade');
            $table->foreignId('disability_type_id')
                ->references('id')
                ->on('disability_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pathway_disability_types');
    }
};
