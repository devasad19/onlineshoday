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
        Schema::create('delivery_charge_rules', function (Blueprint $table) {

            $table->id();

            // kg_liter, piece, packet, dozen etc.
            $table->string('unit_type');

            // Quantity range
            $table->integer('min_quantity');
            $table->integer('max_quantity');

            // Delivery charge
            $table->integer('charge');

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_charge_rules');
    }
};
