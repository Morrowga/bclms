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
        Schema::create('storybook_themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storybook_id')
                ->references('id')
                ->on('storybooks')->onDelete('cascade');
            $table->foreignId('theme_id')
                ->references('id')
                ->on('themes')->onDelete('cascade');
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
        Schema::dropIfExists('storybook_themes');
    }
};
