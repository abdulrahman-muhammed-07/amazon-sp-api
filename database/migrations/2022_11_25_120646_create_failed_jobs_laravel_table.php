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
        Schema::create('failed_jobs_laravel', function (Blueprint $table) {
            $table->id();
            $table->text('job_name')->nullable();
            $table->text('status')->nullable();
            $table->string('time')->nullable();
            $table->json('fail_reason')->nullable();
            $table->unsignedBigInteger('user_store_id', false);
            $table->foreign('user_store_id')->references('store_id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('failed_jobs_laravel');
    }
};
