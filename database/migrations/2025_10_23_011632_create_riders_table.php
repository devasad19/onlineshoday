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
        Schema::create('riders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->integer('age');
            $table->string('edu_qualification'); // ssc er niche, ssc pass, hsc pass, honurs pass 
            $table->string('institute'); 
            $table->string('phone')->unique();
            $table->string('father_phone')->unique();
            $table->string('address')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('nid_image')->nullable();
            $table->string('photo')->nullable();
            $table->integer('total_delivered')->default(0);
            $table->integer('on_time_delivery')->default(0);
            $table->integer('pending_orders')->default(0);
            $table->integer('cancel_delivery')->default(0);
            $table->integer('available')->default(1);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riders');
    }
};
