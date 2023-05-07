<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('random_id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('password');
            $table->boolean('isVerified')->default(false);
            $table->enum('type', ['admin', 'customer', 'seller'])->default('customer');  // 0 => admin, 1 => customer, 2 => seller

            $table->string('vehicle_name')->nullable();
            $table->string('plate_num')->nullable();
            $table->foreignId('food_type_id')->nullable()->constrained('food_types');
            $table->string('food_truck_licence')->nullable();
            $table->string('vehicle_image')->nullable();
            $table->enum('delivery', [0, 1])->default(0);   // 0 => pickup, 1 => delivery
            $table->double('deliveryPrice')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
