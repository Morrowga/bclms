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
        Schema::create('pathway_storybook', function (Blueprint $table) {
            $table->foreignId('pathway_id')->nullable()->references('id')->on('pathways')->cascadeOnDelete();
            $table->foreignId('storybook_id')->nullable()->references('id')->on('storybooks')->cascadeOnDelete();
            $table->integer('sequence')->nullable();
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
        Schema::dropIfExists('pathway_storybook');
    }
};
