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
    Schema::table('items', function (Blueprint $table) {
        // Menambah kolom deskripsi (bisa panjang) dan gambar (path file)
        $table->text('description')->nullable()->after('name');
        $table->string('image')->nullable()->after('description');
    });
}

public function down()
{
    Schema::table('items', function (Blueprint $table) {
        $table->dropColumn(['description', 'image']);
    });
}
};
