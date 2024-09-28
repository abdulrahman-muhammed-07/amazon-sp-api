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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->char('asin', 36)->nullable();
            $table->char('sku', 36)->nullable();
            $table->text('SubscriptionId');
            $table->text('NotificationId');
            $table->json('error')->nullable();
            $table->json('changes')->nullable();
            $table->timestamp('EventTime')->nullable();
            $table->timestamp('CreatedDate')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
