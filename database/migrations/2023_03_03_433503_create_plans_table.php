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
            $table->float('storage_limit')->nullable();
            $table->integer('num_student_license');
            $table->boolean('allow_customisation');
            $table->boolean('allow_personalisation');
            $table->enum('status', ['ACTIVE', 'INACTIVE']);
            $table->decimal('price', 15, 2)->nullable();
            $table->string('payment_period');  //MONTHLY/YEARLY
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
        Schema::dropIfExists('plans');
    }
};
