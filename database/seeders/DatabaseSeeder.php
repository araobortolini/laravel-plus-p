<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CRIAR O SEU USUÁRIO MASTER (Acesso Total)
        // Adicionamos 'is_master' => true para garantir a prioridade no DashboardController
        User::factory()->create([
            'name' => 'Administrador Master',
            'email' => 'admin@admin.com', 
            'password' => Hash::make('admin123'),
            'is_master' => true, // <--- CAMPO ESSENCIAL ADICIONADO
            'tenant_id' => null, // Master não pertence a nenhuma revenda específica
        ]);

        // 2. CRIAR AS 50 REVENDAS DE TESTE
        for ($i = 1; $i <= 50; $i++) {
            $index = str_pad($i, 2, '0', STR_PAD_LEFT);
            $email = "{$index}@01.com";

            // Cria a Revenda (Tenant)
            $tenant = Tenant::factory()->create([
                'name' => "Revenda {$index}",
                'email' => $email,
            ]);

            // Cria o Usuário da Revenda
            User::factory()->create([
                'name' => "Admin {$index}",
                'email' => $email,
                'password' => Hash::make('01'), // Senha padrão: 01
                'tenant_id' => $tenant->id,    // Vínculo com a revenda
                'is_master' => false,          // Garante que revendedores não sejam master
            ]);

            // Cria 5 lojas para cada uma dessas revendas
            Store::factory(5)->create([
                'tenant_id' => $tenant->id,
                'name' => "Loja " . fake()->company() . " - Unidade {$index}"
            ]);
        }
    }
}