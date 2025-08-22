<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Ajustar longitudes
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'codigo'))   $table->string('codigo', 100)->nullable()->change();
            if (Schema::hasColumn('users', 'puesto'))   $table->string('puesto', 150)->nullable()->change();
            if (Schema::hasColumn('users', 'telefono')) $table->string('telefono', 30)->nullable()->change();
            if (Schema::hasColumn('users', 'extension'))$table->string('extension', 10)->nullable()->change();
        });

        // 2) Reemplazar FK a restrictOnDelete (si existen columna y tabla destino)
        if (Schema::hasColumn('users', 'dependencia_id') && Schema::hasTable('inventarios_dependencias')) {
            Schema::table('users', function (Blueprint $table) {
                // quitar FK previa si existe
                try { $table->dropForeign(['dependencia_id']); } catch (\Throwable $e) {}
                // volver a crear FK con RESTRICT
                $table->foreign('dependencia_id')
                    ->references('id')
                    ->on('inventarios_dependencias')
                    ->restrictOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Revertir longitudes a algo genérico
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'codigo'))   $table->string('codigo', 255)->nullable()->change();
            if (Schema::hasColumn('users', 'puesto'))   $table->string('puesto', 255)->nullable()->change();
            if (Schema::hasColumn('users', 'telefono')) $table->string('telefono', 255)->nullable()->change();
            if (Schema::hasColumn('users', 'extension'))$table->string('extension', 255)->nullable()->change();
        });

        // Opcional: regresar a nullOnDelete
        if (Schema::hasColumn('users', 'dependencia_id') && Schema::hasTable('inventarios_dependencias')) {
            Schema::table('users', function (Blueprint $table) {
                try { $table->dropForeign(['dependencia_id']); } catch (\Throwable $e) {}
                $table->foreign('dependencia_id')
                    ->references('id')
                    ->on('inventarios_dependencias')
                    ->nullOnDelete();
            });
        }
    }
};

