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
            $table->unsignedBigInteger('subscription_id')->nullable()
                ->references('id')
                ->on('subscriptions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable()
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->unsignedBigInteger('plan_id')->nullable()
                ->references('id')
                ->on('plans')->onDelete('cascade');
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
