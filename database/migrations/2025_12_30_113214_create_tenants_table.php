<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // inicio do bloco migration_tenants ...
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            // UUID é crucial para evitar duplicidade de IDs entre o Windows Offline e a Nuvem
            $table->uuid('id')->primary();

            $table->string('name'); // Nome da Revenda
            $table->string('domain')->unique()->nullable(); // Ex: revenda1.sistema.com
            $table->string('document')->nullable(); // CPF ou CNPJ
            $table->boolean('is_active')->default(true); // Controle de bloqueio/inatividade

            $table->timestamps();
        });
    }
    // do bloco migration_tenants.

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};