<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('visits', function (Blueprint $table) {
        $table->id();
        $table->string('visitor_name'); // Nama pengunjung
        $table->string('visitor_id');   // NIM atau ID
        $table->enum('purpose', ['belajar', 'pinjam']); // Keperluan
        $table->timestamps(); // Created_at mencatat waktu masuk
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
