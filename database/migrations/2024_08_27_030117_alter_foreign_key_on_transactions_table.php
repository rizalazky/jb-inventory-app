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
        Schema::table('transaction_details', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['transaction_id']);

            // Re-create the foreign key constraint with onDelete and onUpdate cascade
            $table->foreign('transaction_id')
                ->references('id')->on('transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('transaction_details', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['transaction_id']);

            // Re-create the original foreign key constraint (without cascades)
            $table->foreign('transaction_id')
                ->references('id')->on('transactions');
        });
    }
};
