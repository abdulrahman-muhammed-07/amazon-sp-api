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
        Schema::create('amazon_reports', function (Blueprint $table) {
            $table->id();
            $table->text('report_id');
            $table->text('report_type');
            $table->boolean('report_status')->default(false);
            $table->text('report_url')->nullable();
            $table->text('report_document_id')->nullable();
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
        Schema::dropIfExists('amazon_reports');
    }
};
