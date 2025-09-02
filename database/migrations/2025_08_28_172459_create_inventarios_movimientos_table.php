<?php

use App\Enums\EstadoAprobacion;
use App\Enums\MovimientoTipo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventarios_movimientos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('equipo_id'); // FK inventarios_equipos.id
            $table->enum('tipo_movimiento', MovimientoTipo::values());

            $table->unsignedBigInteger('responsable_id'); // FK users.id (quien registra)
            $table->unsignedBigInteger('usuario_asignado_id')->nullable(); // FK users.id (si aplica)

            $table->unsignedBigInteger('dependencia_origen_id')->nullable();
            $table->unsignedBigInteger('dependencia_destino_id')->nullable();

            $table->date('fecha_movimiento');
            $table->date('fecha_retorno_esperada')->nullable();

            $table->text('motivo')->nullable();

            $table->enum('estado_aprobacion', EstadoAprobacion::values())->default(EstadoAprobacion::Pendiente->value);
            $table->unsignedBigInteger('aprobador_id')->nullable(); // quien aprobó/rechazó el último estado
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->text('comentarios_aprobacion')->nullable();

            $table->timestamps();

            // Índices
            $table->index(['equipo_id', 'tipo_movimiento']);
            $table->index(['estado_aprobacion', 'fecha_movimiento']);
            $table->index(['dependencia_origen_id', 'dependencia_destino_id'], 'mov_dep_orig_dest_idx'); 

            // FKs (asumiendo nombres de tablas del proyecto)
            $table->foreign('equipo_id')->references('id')->on('inventarios_equipos')->cascadeOnDelete();
            $table->foreign('responsable_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('usuario_asignado_id')->references('id')->on('users')->nullOnDelete();

            $table->foreign('dependencia_origen_id')->references('id')->on('inventarios_dependencias')->nullOnDelete();
            $table->foreign('dependencia_destino_id')->references('id')->on('inventarios_dependencias')->nullOnDelete();

            $table->foreign('aprobador_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventarios_movimientos');
    }
};
