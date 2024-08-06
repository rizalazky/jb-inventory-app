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
        Schema::create('unit_conversions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('unit_id_from');
            $table->unsignedBigInteger('unit_id_to');
            $table->double('value');
            $table->timestamps();

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_conversions');
    }
};
