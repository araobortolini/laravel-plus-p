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
            // Torna o documento, nome, email e telefone únicos no banco de dados
            $table->unique('document');
            $table->unique('name');
            $table->unique('phone');
            // O email já deve ser único da migration anterior, mas se não for, adicione aqui:
            // $table->unique('email'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropUnique(['document']);
            $table->dropUnique(['name']);
            $table->dropUnique(['phone']);
        });
    }
};