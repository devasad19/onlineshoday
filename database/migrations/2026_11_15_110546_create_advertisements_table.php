
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('category');
            
            // own_service, partner_service, general_ad
            $table->string('ad_type');

            $table->string('provider_name')->nullable();
            $table->string('provider_type')->nullable();

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->string('image')->nullable();

            $table->string('location')->nullable();
            $table->string('phone')->nullable();

            $table->string('price_label')->nullable();

            // pending, approved, rejected
            $table->string('status')->default('pending');

            $table->text('rejection_reason')->nullable();

            $table->boolean('is_featured')->default(false);

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
