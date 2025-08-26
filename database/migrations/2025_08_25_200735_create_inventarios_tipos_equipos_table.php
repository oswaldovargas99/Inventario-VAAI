<?php

// database/migrations/2025_08_22_100000_create_inventarios_tipos_equipos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventarios_tipos_equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('inventarios_tipos_equipos');
    }
};

