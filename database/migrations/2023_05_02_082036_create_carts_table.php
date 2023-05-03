<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constarained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constarained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constarained('products')->cascadeOnDelete();
            $table->enum('spicy', [0, 1])->default(0);  // 0 => notSpicy, 1 => spicy
            $table->string('without_id')->nullable();
            $table->double('quantity')->default(1);
            $table->double('productPrice');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
