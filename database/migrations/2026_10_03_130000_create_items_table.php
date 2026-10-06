<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ============================================================
        // ITEMS — El ítem es una entidad permanente de la institución.
        // No pertenece a una persona: sobrevive a los cambios de titular.
        // ============================================================
        Schema::create('items', function (Blueprint $table) {
            $table->id('id_item');
            $table->string('numero_item', 20)->unique();
            $table->string('descripcion', 150)->nullable();
            $table->foreignId('id_carrera')->nullable()->constrained('carreras', 'id_carrera')->nullOnDelete();
            $table->string('unidad', 100)->nullable();
            $table->enum('estado', ['VACANTE', 'OCUPADO'])->default('VACANTE');
            $table->date('fecha_vacancia')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['estado', 'id_carrera']);
        });

        // ============================================================
        // ITEM_USUARIO — Un ítem puede tener 2, 3 o más custodios,
        // y una persona puede tener varios ítems.
        // ============================================================
        Schema::create('item_usuario', function (Blueprint $table) {
            $table->id('id_item_usuario');
            $table->foreignId('id_item')->constrained('items', 'id_item')->cascadeOnDelete();
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->enum('tipo', ['TITULAR', 'SECUNDARIO', 'RESPONSABLE'])->default('TITULAR');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->timestamps();

            $table->unique(['id_item', 'id_usuario']);
            $table->index('id_usuario');
        });

        // ============================================================
        // ACTIVOS_FIJOS — El activo se ancla al ítem al que pertenece.
        // id_custodio sigue siendo quién lo tiene físicamente hoy.
        // ============================================================
        Schema::table('activos_fijos', function (Blueprint $table) {
            $table->foreignId('id_item')->nullable()->constrained('items', 'id_item')->nullOnDelete();

            $table->index(['id_item', 'estado_registro']);
        });
    }

    public function down(): void
    {
        Schema::table('activos_fijos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_item');
            $table->dropIndex(['id_item', 'estado_registro']);
        });

        Schema::dropIfExists('item_usuario');
        Schema::dropIfExists('items');
    }
};
