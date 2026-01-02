<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a migração para adicionar a coluna email.
     */
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Adiciona a coluna email que não existe na sua tabela atual
            // O unique() garante que não existam duas revendas com o mesmo email
            $table->string('email')->unique()->nullable()->after('document');
        });
    }

    /**
     * Reverte a migração removendo a coluna.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};