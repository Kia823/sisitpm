<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ============================================================
        // ACTIVO_FIJO  — Se capitaliza: equipos, máquinas, endblocklos.
        // NO_ACTIVO    — Se inventaría pero no se capitaliza: escobas,
        //               papeleras, engrampadoras, perforadoras.
        // ============================================================
        Schema::table('activos_fijos', function (Blueprint $table) {
            $table->enum('tipo_bien', ['ACTIVO_FIJO', 'NO_ACTIVO'])
                ->default('ACTIVO_FIJO')
                ->after('codigo_activo');

            $table->index('tipo_bien');
        });
    }

    public function down(): void
    {
        Schema::table('activos_fijos', function (Blueprint $table) {
            $table->dropIndex('tipo_bien');
            $table->dropColumn('tipo_bien');
        });
    }
};