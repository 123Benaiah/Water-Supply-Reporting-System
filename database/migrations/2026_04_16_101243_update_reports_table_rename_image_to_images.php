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
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->json('images')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('images');
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }
};
