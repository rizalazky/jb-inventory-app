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
        Schema::table('product_prices', function (Blueprint $table) {
            //
            $table->double('unit_conversion_value')->nullable();
            $table->dropColumn('price');

            $table->double('buy_price')->nullable();
            $table->double('sell_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('product_prices', function (Blueprint $table) {
            $table->dropColumn('unit_conversion_value');

            $table->double('price');

            $table->dropColumn('buy_price');
            $table->dropColumn('sell_price');
        });
    }
};
