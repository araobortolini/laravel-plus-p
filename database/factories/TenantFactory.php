<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        // Usando Faker em português para gerar CNPJ e nomes reais
        $faker = \Faker\Factory::create('pt_BR');

        return [
            'seller_name' => $faker->name(),
            'name'        => $faker->company(),
            'document'    => $faker->cnpj(false),
            'email'       => $faker->unique()->companyEmail(),
            'phone'       => $faker->phoneNumber(),
            'is_active'   => true,
        ];
    }
}