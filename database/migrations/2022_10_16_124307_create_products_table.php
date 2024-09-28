<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_store_id', false);
            $table->char('product_uuid', 36)->index()->nullable();
            $table->char('variant_uuid', 36)->index()->nullable();
            $table->char('seller_sku', 36)->index()->nullable();
            $table->char('amazon_asin_id', 36)->index()->nullable();
            $table->char('parent_sku', 36)->index()->nullable();
            $table->text('color')->nullable();
            $table->text('color_standardized_values')->nullable();
            $table->text('variation_theme')->nullable();
            $table->text('department')->nullable();
            $table->text('product_description')->nullable();
            $table->text('brand')->nullable();
            $table->text('item_name')->nullable();
            $table->text('externally_assigned_product_identifier')->nullable();
            $table->text('externally_assigned_product_identifier_type')->nullable();
            $table->float('list_price')->nullable();
            $table->text('product_tax_code')->nullable();
            $table->text('condition_type')->nullable();
            $table->text('size')->nullable();
            $table->text('main_product_image_locator')->nullable();
            $table->text('child_relationship_type')->nullable();
            $table->text('status')->nullable();
            $table->text('product_type')->nullable();
            $table->text('asin')->nullable();
            $table->json('bullet_points_array')->nullable();
            $table->json('offers_array')->nullable();
            $table->json('gift_options')->nullable();
            $table->enum('parentage_level', ['parent', 'child', 'not_assigned'])->nullable();
            $table->integer('quantity', false, true);
            $table->json('issues')->nullable();
            $table->integer('updated_at_amazon')->nullable();
            $table->integer('updated_at_Application')->nullable();
            $table->integer('updated_at_amazon_qty_price')->nullable();
            $table->integer('updated_at_Application_qty_price')->nullable();
            $table->enum('action_from', ['Application', 'amazon']);
            $table->char('lex_hash', 32)->nullable();
            $table->char('amazon_hash', 32)->nullable();
            $table->char('lex_hash_qty_price', 32)->nullable();
            $table->char('amazon_hash_qty_price', 32)->nullable();
            $table->text('status_report')->nullable();
            $table->boolean('sent')->default(false);
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
        Schema::dropIfExists('products');
    }
};
