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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string("transaction_number");
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string("type");
            $table->double('sub_total');
            $table->double('discount');
            $table->double('total');
            $table->unsignedBigInteger("user_by");
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')->on('customers');
            $table->foreign('supplier_id')
                ->references('id')->on('suppliers');
            $table->foreign('user_by')
                ->references('id')->on('users');
                // ->onUpdate('cascade')
                // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
