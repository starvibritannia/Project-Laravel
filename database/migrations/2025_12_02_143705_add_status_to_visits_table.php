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
    Schema::table('visits', function (Blueprint $table) {
        // Default 'active' artinya sedang di lab
        $table->enum('status', ['active', 'completed'])->default('active')->after('purpose');
    });
}

    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
