<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void      
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();            
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->enum('status', ['pending', 'processing', 'deliverd', 'picked up', 'cancel_by_customer', 'accepted_by_seller', 'rejected_by_seller'])->default('pending');
            $table->enum('confirmed', [0, 1])->default(0);  // 0-unconfirmed, 1-confirmed
            $table->double('quantity');
            $table->double('productPrice');
            $table->double('deliveryPrice')->nullable();
            $table->double('total');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
