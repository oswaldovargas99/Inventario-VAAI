<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('codigo')->nullable()->after('id');
            $table->string('puesto')->nullable()->after('name');
            $table->string('telefono')->nullable()->after('email');
            $table->string('extension')->nullable()->after('telefono');
            $table->foreignId('dependencia_id')->nullable()
                ->constrained('inventarios_dependencias')
                ->nullOnDelete()
                ->after('extension');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dependencia_id');
            $table->dropColumn(['codigo','puesto','telefono','extension']);
        });
    }
};
