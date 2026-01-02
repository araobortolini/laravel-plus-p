<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // inicio do bloco migration_stores ...
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID para suportar sincronização

            // Relacionamento: A loja pertence a uma Revenda (Tenant)
            $table->foreignUuid('tenant_id')->constrained('tenants')->onDelete('cascade');

            $table->string('name');
            $table->string('internal_code')->nullable(); // Código interno para facilitar suporte
            $table->boolean('is_offline_enabled')->default(false); // Painel Admin define se a loja pode usar o app Windows
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
    // do bloco migration_stores.

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};