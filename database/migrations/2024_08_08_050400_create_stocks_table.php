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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("product_price_id");
            $table->string("type"); // enum "in" or "out"
            // $table->unsignedBigInteger("transaction_id")->nullable();
            // $table->unsignedBigInteger("transaction_detail_id")->nullable();
            $table->double("quantity");
            $table->string("notes");
            $table->unsignedBigInteger("user_by");
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('product_price_id')
                ->references('id')->on('product_prices')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_by')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // $table->foreign('transaction_id')
            //     ->references('id')->on('transactions')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');

            // $table->foreign('transaction_detail_id')
            //     ->references('id')->on('transaction_details')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
