<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_store_id', false);
            $table->json('settings')->nullable();
            $table->json('mapping_settings')->nullable();
            $table->json('mapping_settings_defaults')->nullable();
            $table->json('mapping_settings_properties')->nullable();
            $table->foreign('user_store_id')->references('store_id')->on('users')->onDelete('cascade');
            $table->primary('user_store_id');
            $table->json('last_updates')->nullable();
            $table->text('LWA_CLIENT_ID')->nullable();
            $table->text('LWA_CLIENT_SECRET')->nullable();
            $table->text('AWS_ACCESS_KEY')->nullable();
            $table->text('AWS_SECRET_ACCESS_KEY')->nullable();
            $table->text('SELLER_ID')->nullable();
            $table->text('MARKET_PLACE_ID')->nullable();
            $table->text('AMAZON_APP_ID')->nullable();
            $table->text('ASIN')->nullable();
            $table->text('REPORT_TYPE')->nullable();
            $table->text('AWS_DEFAULT_REGION')->nullable();
            $table->text('AWS_BUCKET')->nullable();
            $table->text('AWS_ROLE_ARN')->nullable();
            $table->text('AWS_USE_PATH_STYLE_ENDPOINT')->nullable();
            $table->text('AWS_ACCESS_KEY_ID_IMAGE_UPLOAD')->nullable();
            $table->text('DEVELOPER_ID')->nullable();
            $table->text('LWA_ACCESS_TOKEN')->nullable();
            $table->text('LWA_REFRESH_TOKEN')->nullable();
            $table->boolean('master_switch_sync_all_plugin')->nullable();
            $table->boolean('sync_Application_amazon_price')->nullable();
            $table->boolean('sync_Application_amazon_qty')->nullable();
            $table->boolean('sync_amazon_Application_price')->nullable();
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
        Schema::dropIfExists('user_settings');
    }
};
