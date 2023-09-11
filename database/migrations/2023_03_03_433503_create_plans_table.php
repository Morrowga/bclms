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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('storage_limit', 10, 2)->nullable();
            $table->integer('num_student_profiles');
            $table->boolean('allow_customisation');
            $table->boolean('allow_personalisation');
            $table->boolean('full_library_access');
            $table->boolean('concurrent_access');
            $table->boolean('weekly_learning_report');
            $table->boolean('dedicated_student_report');
            $table->enum('status', ['ACTIVE', 'INACTIVE']);
            $table->decimal('price', 15, 2)->nullable();
            $table->enum('payment_period', ['MONTHLY', 'YEARLY']);
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
        Schema::dropIfExists('plans');
    }
};
