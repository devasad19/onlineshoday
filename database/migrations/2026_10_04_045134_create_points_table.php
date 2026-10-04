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
        Schema::create('points', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | যার points
            |--------------------------------------------------------------------------
            */
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | কোন order থেকে
            |--------------------------------------------------------------------------
            */
            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Points
            |--------------------------------------------------------------------------
            */
            $table->integer('points');


            /*
            |--------------------------------------------------------------------------
            | earn / spend / reverse
            |--------------------------------------------------------------------------
            */
            $table->string('type', 30);


            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */
            $table->string('description')->nullable();


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
