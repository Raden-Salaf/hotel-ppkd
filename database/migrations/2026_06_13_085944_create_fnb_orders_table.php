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
        Schema::create('fnb_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();      // F-20260613-001
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->string('room_number')->nullable();   // untuk walk-in tanpa booking
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['queue', 'processing', 'done', 'cancelled'])->default('queue');
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fnb_orders');
    }
};
