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
            // Verifica se a coluna 'seller_name' não existe antes de criar
            if (!Schema::hasColumn('tenants', 'seller_name')) {
                $table->string('seller_name')->after('id');
            }
            
            // Verifica se a coluna 'document' não existe antes de criar (evita o erro SQLSTATE[42701])
            if (!Schema::hasColumn('tenants', 'document')) {
                $table->string('document')->after('name');
            }
            
            // Verifica se a coluna 'phone' não existe antes de criar
            if (!Schema::hasColumn('tenants', 'phone')) {
                $table->string('phone')->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Remove as colunas apenas se elas existirem
            $columns = [];
            
            if (Schema::hasColumn('tenants', 'seller_name')) $columns[] = 'seller_name';
            if (Schema::hasColumn('tenants', 'document')) $columns[] = 'document';
            if (Schema::hasColumn('tenants', 'phone')) $columns[] = 'phone';

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};