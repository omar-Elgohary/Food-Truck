<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->string('name');
            $table->double('price');
            $table->double('calories');
            $table->text('description');

            $table->enum('spicy', [0, 1])->default(0);  // 0 => notSpicy, 1 => spicy
            $table->foreignId('without_id')->nullable()->constrained('withouts');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
