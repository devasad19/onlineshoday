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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('bazar_id');
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamp('price_updated_at')->nullable();
            $table->integer('stock')->default(0);
            $table->string('unit');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            // Optional foreign key (if category table exists)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('bazar_id')->references('id')->on('bazars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
