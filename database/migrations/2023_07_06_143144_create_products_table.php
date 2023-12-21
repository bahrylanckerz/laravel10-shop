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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_category_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100)->nullable();
            $table->string('slug', 200)->nullable();
            $table->text('description')->nullable();
            $table->text('details')->nullable();
            $table->double('price', 10, 2)->nullable();
            $table->double('compare_price', 10, 2)->nullable();
            $table->string('sku', 50)->nullable();
            $table->string('barcode', 50)->nullable();
            $table->integer('qty')->nullable()->default(0);
            $table->enum('track_qty', ['Yes', 'No'])->nullable()->default('No');
            $table->enum('is_featured', ['Yes', 'No'])->nullable()->default('No');
            $table->string('image', 100)->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
