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
        Schema::create('quantity_logs', function (Blueprint $table) {
            $table->id();
            $table->char('sku', 36);
            $table->char('product_uuid', 36);
            $table->char('variant_uuid', 36);
            $table->integer('old_quantity', false, true);
            $table->integer('new_quantity', false, true);
            $table->float('old_price')->nullable();
            $table->float('new_price')->nullable();
            $table->text('type')->nullable();
            $table->enum('change_from', ['amazon', 'Application']);
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
        Schema::dropIfExists('quantity_logs');
    }
};
