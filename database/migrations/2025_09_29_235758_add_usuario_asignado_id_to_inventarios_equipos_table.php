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
        // Usamos Schema::table() porque la tabla ya existe y solo la vamos a modificar.
        Schema::table('inventarios_equipos', function (Blueprint $table) {
            
            // Esta es la línea que añade tu nueva columna
            $table->foreignId('usuario_asignado_id')
                  ->nullable()                      // Permite que el campo esté vacío (para equipos en almacén)
                  ->after('estado')                 // La coloca justo después de la columna 'estado'
                  ->constrained('users')            // Crea la relación con la tabla 'users'
                  ->onDelete('set null');          // Si un usuario se elimina, el equipo queda sin asignar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventarios_equipos', function (Blueprint $table) {
            // Esto permite revertir el cambio de forma segura si es necesario
            $table->dropForeign(['usuario_asignado_id']);
            $table->dropColumn('usuario_asignado_id');
        });
    }
};