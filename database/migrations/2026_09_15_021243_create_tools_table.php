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
    Schema::create('tools', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        $table->string('name');
        $table->text('specification')->nullable();
        $table->integer('stock')->default(0);
        $table->enum('condition', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
        $table->string('image')->nullable();
        $table->enum('status', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
