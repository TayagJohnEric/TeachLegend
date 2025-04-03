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
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Customer ID
            $table->foreignId('technician_id')->nullable()->constrained('users', 'id')->onDelete('set null'); // Assigned technician
            $table->string('service_type');
            $table->dateTime('appointment_date')->useCurrent();
            $table->string('status')->default('pending'); // Consider handling enum in the model
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Soft deletes instead of permanent deletion
            $table->index('appointment_date'); // Index for better performance
            $table->index('status'); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            //
        });
    }
};
