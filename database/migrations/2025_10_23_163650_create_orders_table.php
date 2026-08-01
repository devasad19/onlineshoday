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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // ✅ Client & Rider Relationship
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('rider_id')->nullable();

            // ✅ Order Basic Info
            $table->string('order_code')->unique();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_method')->nullable(); // cash, bkash, card etc.
            $table->string('delivery_address')->nullable();

            // ✅ Delivery & Status
            $table->enum('status', ['pending', 'accepted', 'delivered', 'cancelled'])->default('pending');
            $table->timestamp('delivery_time')->nullable();
            $table->timestamp('delivery_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            // ✅ Rider Performance Tracking
            $table->string('delivered_status')->default(false);
            $table->string('notes')->nullable();

            $table->timestamps();

            // ✅ Foreign Keys (Optional)
            $table->foreign('rider_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
