<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona as colunas que faltavam na tabela original de 2025.
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Adicionamos os campos novos APÓS o campo 'name' para organizar
            $table->string('document')->unique()->nullable()->after('name');
            $table->string('email')->unique()->nullable()->after('document');
            $table->string('phone')->nullable()->after('email');
            
            // Adicionamos o SoftDeletes (a lixeira do Laravel)
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Remove as colunas caso você precise desfazer a migração.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['document', 'email', 'phone']);
            $table->dropSoftDeletes();
        });
    }
};