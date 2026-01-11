<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');

        return [
            'name'     => $faker->company() . ' - Unidade',
            'document' => $faker->cnpj(false),
            'email'    => $faker->unique()->safeEmail(),
            'phone'    => $faker->phoneNumber(),
            // 'tenant_id' será definido pelo Seeder
        ];
    }
}