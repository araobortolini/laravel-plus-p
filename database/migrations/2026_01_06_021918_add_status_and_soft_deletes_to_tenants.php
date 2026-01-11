<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Verifica se a coluna 'is_active' já não foi criada na tentativa anterior
            if (!Schema::hasColumn('tenants', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('phone');
            }
            
            // Verifica se a coluna 'deleted_at' do SoftDeletes já não foi criada
            if (!Schema::hasColumn('tenants', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Remove as colunas se elas existirem (para evitar erros no rollback)
            if (Schema::hasColumn('tenants', 'is_active')) {
                $table->dropColumn('is_active');
            }
            
            if (Schema::hasColumn('tenants', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};