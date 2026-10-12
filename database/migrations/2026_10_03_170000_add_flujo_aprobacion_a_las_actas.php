<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =====================================================
        // ACTAS DE BAJA — quedan PENDIENTES hasta que la
        // administradora las aprueba.
        // =====================================================
        Schema::table('actas_baja', function (Blueprint $table) {
            $table->enum('estado', ['PENDIENTE', 'APROBADA', 'RECHAZADA'])
                  ->default('PENDIENTE')
                  ->after('archivo_resolucion');
            $table->foreignId('id_aprobador')
                  ->nullable()
                  ->constrained('usuarios', 'id_usuario')
                  ->nullOnDelete();
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->text('comentario_aprobacion')->nullable();

            // Sustitución: el equipo viejo se da de baja y entra uno nuevo
            // tomado del almacén.
            $table->boolean('es_sustitucion')->default(false);
            $table->json('datos_sustituto')->nullable();
            $table->foreignId('id_activo_sustituto')
                  ->nullable()
                  ->constrained('activos_fijos', 'id_activo')
                  ->nullOnDelete();

            $table->index(['estado', 'id_acta_baja']);
        });

        // =====================================================
        // ACTAS DE TRANSFERENCIA — el bien espera en el ambiente de
        // origen hasta que la administradora la aprueba.
        // =====================================================
        Schema::table('actas_transferencia', function (Blueprint $table) {
            $table->enum('estado', ['PENDIENTE', 'APROBADA', 'RECHAZADA'])
                  ->default('PENDIENTE')
                  ->after('fecha_transferencia');
            $table->foreignId('id_aprobador')
                  ->nullable()
                  ->constrained('usuarios', 'id_usuario')
                  ->nullOnDelete();
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->text('comentario_aprobacion')->nullable();

            // Estado que tenía el activo antes de quedar en espera, para
            // devolverlo si la administración rechaza la transferencia.
            $table->string('estado_anterior', 25)->nullable();

            $table->index(['estado', 'id_acta_transferencia']);
        });
    }

    public function down(): void
    {
        Schema::table('actas_transferencia', function (Blueprint $table) {
            $table->dropIndex(['estado', 'id_acta_transferencia']);
            $table->dropColumn([
                'estado',
                'id_aprobador',
                'fecha_aprobacion',
                'comentario_aprobacion',
                'estado_anterior',
            ]);
        });

        Schema::table('actas_baja', function (Blueprint $table) {
            $table->dropIndex(['estado', 'id_acta_baja']);
            $table->dropColumn([
                'estado',
                'id_aprobador',
                'fecha_aprobacion',
                'comentario_aprobacion',
                'es_sustitucion',
                'datos_sustituto',
                'id_activo_sustituto',
            ]);
        });
    }
};