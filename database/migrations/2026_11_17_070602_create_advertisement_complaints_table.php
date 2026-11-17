
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisement_complaints', function (Blueprint $table) {
            $table->id();

            $table->string('complaint_code', 30)->unique();

            // Complaint owner
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Related advertisement
            $table->foreignId('advertisement_id')
                ->nullable()
                ->constrained('advertisements')
                ->nullOnDelete();

            // Complaint information
            $table->string('complaint_type', 50);
            $table->text('description');

            // Optional evidence image
            $table->string('evidence')->nullable();

            // Customer's expected solution
            $table->string('desired_resolution', 100)->nullable();

            // Complaint status
            $table->string('status', 30)->default('received')->index();

            // Admin response (for future admin panel)
            $table->text('admin_response')->nullable();

            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['advertisement_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisement_complaints');
    }
};
