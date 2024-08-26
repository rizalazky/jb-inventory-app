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
        Schema::table('stocks',function(Blueprint $table){
            // $table->dropForeign(['product_price_id']);

            $table->double('price')->nullable();
            $table->unsignedBigInteger("transaction_id")->nullable();
            $table->unsignedBigInteger("transaction_detail_id")->nullable();

            $table->foreign('transaction_id')
                ->references('id')->on('transactions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('transaction_detail_id')
                ->references('id')->on('transaction_details')
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
        Schema::table('stocks',function(Blueprint $table){
            $table->dropForeign(['transaction_id']);
            $table->dropForeign(['transaction_detail_id']);

            $table->dropColumn('price');
            $table->dropColumn('transaction_id');
            $table->dropColumn('transaction_detail_id');
        });
    }
};
