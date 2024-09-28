<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_auths', function (Blueprint $table) {
            $table->unsignedBigInteger('user_store_id', false);

            $table->text('access_token')->nullable();
            $table->integer('expires_in', false, true)->nullable();
            $table->text('refresh_token')->nullable();
            $table->char('token_type');
            $table->timestamps();


            $table->primary('user_store_id');
            $table->foreign('user_store_id')->references('store_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_auths');
    }
};
