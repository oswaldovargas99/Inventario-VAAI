<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventarios_dependencias', function (Blueprint $table) {
            $table->id()->comment('ID de dependencia');
            $table->string('nombre')->comment('Nombre de la Dependencia');
            $table->string('siglas')->nullable()->comment('Siglas o Abreviatura');
            $table->string('telefono')->nullable()->comment('Teléfono de contacto');
            $table->text('direccion')->nullable()->comment('Dirección, Número, C.P.');
            $table->string('colonia')->nullable()->comment('Colonia de la Dependencia o Centro Universitario');
            $table->string('municipio')->nullable()->comment('Municipio de la Dependencia o Centro Universitario');
            $table->string('estado')->default('Jalisco')->comment('Estado');
            $table->string('pais')->default('México')->comment('País');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inventarios_dependencias');
    }
};


