<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('unit_conversions',function(Blueprint $table){

            $table->dropForeign(['product_id']);
            $table->dropForeign(['unit_id_from']);
            $table->dropForeign(['unit_id_to']);

            $table->dropColumn('product_id');
            $table->dropColumn('unit_id_from');
            $table->dropColumn('unit_id_to');

            $table->unsignedBigInteger('product_price_id_from');
            $table->unsignedBigInteger('product_price_id_to');

            $table->foreign('product_price_id_from')
                ->references('id')->on('product_prices')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('product_price_id_to')
                ->references('id')->on('product_prices')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('unit_conversions',function(Blueprint $table){

            $table->dropForeign(['product_price_id_from']);
            $table->dropForeign(['product_price_id_to']);

            $table->dropColumn('product_price_id_from'); 
            $table->dropColumn('product_price_id_to'); 
            

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('unit_id_from');
            $table->unsignedBigInteger('unit_id_to');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('unit_id_from')
                ->references('id')->on('product_unit')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('unit_id_to')
                ->references('id')->on('product_unit')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }
};
