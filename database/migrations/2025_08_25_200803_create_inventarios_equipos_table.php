<?php

// database/migrations/2025_08_22_100100_create_inventarios_equipos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventarios_equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dependencia_id')->constrained('inventarios_dependencias');
            $table->string('ubicacion_fisica')->nullable();

            $table->foreignId('tipo_equipo_id')->constrained('inventarios_tipos_equipos');

            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->unique();
            $table->string('id_activo_fijo')->nullable();
            $table->string('mac_address')->nullable();

            $table->date('fecha_adquisicion')->nullable();

            $table->enum('estado', [
                'En Almacén','Asignado','En Préstamo','En Mantenimiento','Baja'
            ])->default('En Almacén');

            $table->text('descripcion')->nullable();

            $table->timestamps();
            $table->softDeletes(); // opcional pero recomendado
            $table->index(['dependencia_id','tipo_equipo_id','estado']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('inventarios_equipos');
    }
};

