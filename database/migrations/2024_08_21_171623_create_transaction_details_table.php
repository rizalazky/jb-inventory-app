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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_price_id');
            $table->double('price');
            $table->integer('qty');
            $table->double('discount');
            $table->timestamps();

            $table->foreign('product_price_id')
                ->references('id')->on('product_prices');

            $table->foreign('transaction_id')
                ->references('id')->on('transactions');

            $table->foreign('product_id')
                ->references('id')->on('products');
                // ->onUpdate('cascade')
                // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
