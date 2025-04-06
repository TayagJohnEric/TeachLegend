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
        Schema::create('trade_in_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('component_details');
            $table->enum('condition', ['Like New', 'Used', 'Needs Repair']);
            $table->decimal('pricing', 10, 2);
            $table->enum('status', ['Available', 'Pending', 'Sold', 'Removed'])->default('Available'); 
            $table->string('component_type')->nullable()->index(); // e.g., CPU, GPU, RAM
            $table->string('brand')->nullable()->index(); // Easier filtering
            $table->text('image_path')->nullable(); // Upload image of component
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_in_listings', function (Blueprint $table) {
            //
        });
    }
};
