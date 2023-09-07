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
        Schema::create('stickers', function (Blueprint $table) {
            $table->id();
            $table->string('file_src')->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('gold_coins_needed')->default(0);
            $table->integer('silver_coins_needed')->default(0);
            $table->enum('status', ['ACTIVE', 'INACTIVE']);
            $table->enum('rarity', ['COMMON', 'RARE', 'SUPERRARE', 'EPIC', 'LEGENDARY']);
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
        Schema::dropIfExists('stickers');
    }
};
