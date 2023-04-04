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
        Schema::create('storybooks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->foreignId('organization_id')->nullable()->references('id')->on('organizations')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('synopsis')->nullable();
            $table->longText('description')->nullable();
            $table->string('subject')->nullable();
            $table->string('grade')->nullable();
            $table->string('format')->nullable();
            $table->date('duration')->nullable();
            $table->integer('num_opened')->nullable();
            $table->integer('num_completed')->nullable();
            $table->integer('num_liked')->nullable();
            $table->integer('created_by')->nullable();
            $table->enum('status', [0, 1])->default(0);
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
        Schema::dropIfExists('storybooks');
    }
};
