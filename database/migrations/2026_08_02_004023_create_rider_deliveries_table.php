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
        Schema::create('rider_deliveries', function (Blueprint $table) {

            $table->id();

            $table->foreignId('rider_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('status',[
                'delivered',
                'pending',
                'cancelled'
            ])->default('pending');

            $table->enum('delivery_status',[
                'on_time',
                'late'
            ])->nullable();

            $table->integer('late_time')
                ->default(0)
                ->comment('minutes');

            $table->timestamp('delivered_at')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rider_deliveries');
    }
};
