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
        Schema::create('amazon_feeds', function (Blueprint $table) {
            $table->id();
            $table->string('feed_document_id')->index();
            $table->string('x-amzn-RequestId');
            $table->string('x-amz-apigw-id');
            $table->string('input_feed_document_id')->nullable();
            $table->string('result_feed_document_id')->nullable();
            $table->string('processing_end_time')->nullable();
            $table->string('processing_status')->nullable();
            $table->unsignedBigInteger('submitted_feed_id', false, true)->nullable();
            $table->string('feed_content');
            $table->string('feed_upload_url', 600);
            $table->integer('uploaded_to_status', false, true);
            $table->unsignedBigInteger('user_store_id', false);
            $table->foreign('user_store_id')->references('store_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * input_feed_document_id
     * 'feed_content'
     * x-amzn-RequestId
     *   'feed_document_id',
     *  'feed_upload_url',
     *  'uploaded_to_status',
     *  'expires_in'
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_feeds');
    }
};
