<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // El ítem es la plaza institucional y vive en un ambiente. Así se
        // sabe de antemano quiénes son los custodios del ambiente, aunque
        // todavía no tengan bienes registrados a su nombre.
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('id_ambiente')
                  ->nullable()
                  ->after('id_carrera')
                  ->constrained('ambientes', 'id_ambiente')
                  ->nullOnDelete();

            $table->index('id_ambiente');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropIndex(['id_ambiente']);
            $table->dropConstrainedForeignId('id_ambiente');
        });
    }
};