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
        Schema::create('b2c_subscriptions', function (Blueprint $table) {
            $table->foreignId('subscription_id')->nullable()
                ->references('id')
                ->on('subscriptions')->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()
                ->references('teacher_id')
                ->on('teachers')->onDelete('cascade');
            $table->foreignId('plan_id')->nullable()
                ->references('id')
                ->on('plans')->onDelete('cascade');
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
        Schema::dropIfExists('b2c_subscriptions');
    }
};
