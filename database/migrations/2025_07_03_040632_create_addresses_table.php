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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->string('recipient_name');
            $table->string('phone_number');
            $table->text('street_address'); // Menggunakan text untuk alamat yang mungkin panjang
            $table->string('city');
            $table->string('province');
            $table->string('urban_village');
            $table->string('subdistrict');
            $table->integer('postal_code')->unique();
            $table->string('label')->nullable(); // e.g., 'Home', 'Office', 'Toko'
            $table->boolean('is_default')->default(false); // Default value false
            $table->integer('rajaOngkirId');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};