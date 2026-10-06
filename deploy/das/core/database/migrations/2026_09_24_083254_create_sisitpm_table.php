<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =====================================================
        // 1. CARRERAS
        // =====================================================
        Schema::create('carreras', function (Blueprint $table) {
            $table->id('id_carrera');
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 100);
            $table->timestamps();
        });

        // =====================================================
        // 2. CATEGORÍAS
        // =====================================================
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 100);
            $table->string('descripcion', 255)->nullable();
            $table->unsignedBigInteger('id_ambiente')->nullable();
            $table->timestamps();

            $table->index('nombre');
        });

        // =====================================================
        // 3. USUARIOS
        // =====================================================
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre_completo', 150);
            $table->string('ci', 20)->unique();
            $table->string('email')->nullable()->unique();
            $table->string('cargo', 100)->nullable();
            $table->string('unidad', 100)->nullable();
            $table->string('password');
            $table->string('rol', 50)->default('CUSTODIO');
            $table->foreignId('id_carrera')
                  ->nullable()
                  ->constrained('carreras', 'id_carrera')
                  ->nullOnDelete();
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');

            $table->boolean('puede_verificar')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });

        // =====================================================
        // 4. AMBIENTES
        // =====================================================
        Schema::create('ambientes', function (Blueprint $table) {
            $table->id('id_ambiente');
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 100);
            $table->string('bloque', 20)->nullable();
            $table->integer('piso')->nullable();
            $table->foreignId('id_carrera')
                  ->constrained('carreras', 'id_carrera')
                  ->cascadeOnDelete();
            $table->timestamps();
        });

        // =====================================================
        // 5. FUENTES DE FINANCIAMIENTO
        // =====================================================
        Schema::create('fuentes_financiamiento', function (Blueprint $table) {
            $table->id('id_fuente');
            $table->string('nombre', 100)->unique();
            $table->string('codigo', 10)->nullable();
            $table->timestamps();
        });

        // =====================================================
        // 6. ACTIVOS FIJOS
        // =====================================================
        Schema::create('activos_fijos', function (Blueprint $table) {
            $table->id('id_activo');

            // Identificación
            $table->string('codigo_activo', 50)->unique();
            $table->string('nombre', 150);

            // Descripción detallada
            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();

            // Especificaciones
            $table->string('marca', 80)->nullable();
            $table->string('modelo', 80)->nullable();
            $table->string('numero_serie', 80)->nullable();

            // Valores y fechas
            $table->decimal('valor_adquisicion', 12, 2)->default(0.00);
            $table->date('fecha_adquisicion')->nullable();

            // Estados
            $table->enum('estado_fisico', ['B', 'R', 'M', 'FF'])->default('B');
            $table->enum('estado_registro', ['ACTIVO', 'ASIGNADO', 'EN_TRANSFERENCIA', 'BAJA'])
                  ->default('ACTIVO');

            // Archivos
            $table->string('imagen')->nullable();
            $table->string('ruta_qr')->nullable();
            $table->string('codigo_qr')->nullable();

            // Relaciones
            $table->foreignId('id_categoria')
                  ->constrained('categorias', 'id_categoria');
            $table->foreignId('id_ambiente')
                  ->constrained('ambientes', 'id_ambiente');
            $table->foreignId('id_fuente')
                  ->constrained('fuentes_financiamiento', 'id_fuente');
            $table->foreignId('id_custodio')
                  ->nullable()
                  ->constrained('usuarios', 'id_usuario')
                  ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Índices para reportes agrupados
            $table->index('nombre');
            $table->index('estado_fisico');
            $table->index('fecha_adquisicion');
            $table->index(['id_categoria', 'nombre']);
        });

        // =====================================================
        // 7. ACTAS DE BAJA
        // =====================================================
        Schema::create('actas_baja', function (Blueprint $table) {
            $table->id('id_acta_baja');
            $table->string('numero_acta', 50)->unique();
            $table->foreignId('id_activo')
                  ->constrained('activos_fijos', 'id_activo');
            $table->foreignId('id_usuario')
                  ->constrained('usuarios', 'id_usuario');
            $table->text('motivo');
            $table->date('fecha_baja');
            $table->string('archivo_resolucion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // =====================================================
        // 8. ACTAS DE TRANSFERENCIA
        // =====================================================
        Schema::create('actas_transferencia', function (Blueprint $table) {
            $table->id('id_acta_transferencia');
            $table->string('numero_acta', 50)->unique();
            $table->foreignId('id_activo')
                  ->constrained('activos_fijos', 'id_activo');
            $table->foreignId('id_origen_ambiente')
                  ->constrained('ambientes', 'id_ambiente');
            $table->foreignId('id_destino_ambiente')
                  ->constrained('ambientes', 'id_ambiente');
            $table->foreignId('id_custodio_anterior')
                  ->nullable()
                  ->constrained('usuarios', 'id_usuario')
                  ->nullOnDelete();
            $table->foreignId('id_custodio_nuevo')
                  ->constrained('usuarios', 'id_usuario');
            $table->text('observaciones')->nullable();
            $table->date('fecha_transferencia');
            $table->timestamps();
            $table->softDeletes();
        });

        // =====================================================
        // 9. VERIFICACIONES FÍSICAS
        // =====================================================
        Schema::create('verificaciones_fisicas', function (Blueprint $table) {
            $table->id('id_verificacion');
            $table->foreignId('id_activo')
                  ->constrained('activos_fijos', 'id_activo');
            $table->foreignId('id_ambiente_escaneo')
                  ->constrained('ambientes', 'id_ambiente');
            $table->foreignId('id_verificador')
                  ->constrained('usuarios', 'id_usuario');
            $table->dateTime('fecha_verificacion');
            $table->boolean('es_correspondencia_correcta')->default(true);
            $table->boolean('sincronizado_offline')->default(false);
            $table->string('dispositivo_uuid')->nullable();
            $table->json('datos_extra')->nullable();
            $table->enum('estado_fisico_reportado', ['B', 'R', 'M', 'FF'])->nullable();
            $table->text('observaciones')->nullable();

            // Aprobación
            $table->enum('estado_aprobacion',
                ['PENDIENTE', 'APROBADA', 'RECHAZADA', 'CORREGIDA']
            )->default('PENDIENTE');
            $table->foreignId('id_aprobador')
                  ->nullable()
                  ->constrained('usuarios', 'id_usuario')
                  ->nullOnDelete();
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->text('comentario_aprobacion')->nullable();
            $table->boolean('cambio_estado_fisico_solicitado')->default(false);
            $table->string('estado_fisico_solicitado', 2)->nullable();
            $table->boolean('solicitar_baja')->default(false);
            $table->boolean('verificacion_finalizada')->default(false);

            $table->timestamps();
        });

        // =====================================================
        // 10. CONFIGURACIONES
        // =====================================================
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id('id_configuracion');
            $table->string('institucion_nombre')->default('Instituto Tecnológico "Puerto de Mejillones"');
            $table->string('institucion_direccion')->nullable()->default('El Alto, La Paz - Bolivia');
            $table->string('institucion_director')->nullable()->default('Lic. Jimmy Ovidio Sirpa Choque');
            $table->string('gestion_fiscal', 10)->nullable()->default('2026');
            $table->string('prefijo_activo', 20)->nullable()->default('TPM-');
            $table->boolean('validacion_estricta')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
        Schema::dropIfExists('verificaciones_fisicas');
        Schema::dropIfExists('actas_transferencia');
        Schema::dropIfExists('actas_baja');
        Schema::dropIfExists('activos_fijos');
        Schema::dropIfExists('fuentes_financiamiento');
        Schema::dropIfExists('ambientes');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('carreras');
    }
};
