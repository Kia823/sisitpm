<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ============================================================
        // HISTORIAL DE TITULARES
        // Cuando alguien renuncia, el registro de usuario no se borra:
        // solo cambian sus datos personales. Esta tabla conserva quién
        // estuvo vinculado al ítem antes y quién está ahora.
        // ============================================================
        Schema::create('historial_titulares', function (Blueprint $table) {
            $table->id('id_historial');
            $table->foreignId('id_item')->constrained('items', 'id_item')->cascadeOnDelete();
            $table->foreignId('id_usuario_anterior')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete();
            $table->foreignId('id_usuario_nuevo')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete();
            $table->string('nombre_anterior', 150)->nullable();
            $table->string('nombre_nuevo', 150)->nullable();
            $table->enum('tipo', ['CREACION', 'ASIGNACION', 'DETACH', 'SUSTITUCION', 'RENUNCIA']);
            $table->date('fecha_evento');
            $table->text('motivo')->nullable();
            $table->foreignId('id_usuario_registro')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete();
            $table->timestamps();

            $table->index(['id_item', 'fecha_evento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_titulares');
    }
};
