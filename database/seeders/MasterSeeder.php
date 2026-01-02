<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // inicio do bloco seeder_master ...
    public function run(): void
    {
        User::create([
            'id' => Str::uuid(),
            'name' => 'Master System',
            'email' => 'master@sistema.com',
            'password' => Hash::make('password'),
            'is_master' => true,
        ]);
    }
    // do bloco seeder_master.
}