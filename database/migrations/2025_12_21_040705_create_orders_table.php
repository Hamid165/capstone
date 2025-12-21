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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shipping_rate_id')->nullable()->constrained('shipping_rates');
            $table->decimal('total_price', 12, 2);
            $table->string('snap_token')->nullable();
            $table->enum('payment_status', ['unpaid', 'paid', 'expired'])->default('unpaid');
            $table->enum('shipping_status', ['pending', 'processing', 'shipped', 'completed'])->default('pending');
            $table->string('resi_number')->nullable();
            $table->text('shipping_address_detail')->nullable();
            $table->timestamps();
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
