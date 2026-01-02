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
        Schema::table('users', function (Blueprint $table) {
            // Adiciona a coluna tenant_id como UUID, permitindo nulo (para usuários Master)
            // e cria a restrição de chave estrangeira com a tabela tenants
            $table->foreignUuid('tenant_id')
                  ->nullable()
                  ->after('is_master') // Organiza a coluna após is_master
                  ->constrained('tenants')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};