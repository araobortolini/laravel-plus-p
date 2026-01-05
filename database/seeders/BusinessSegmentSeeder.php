<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessSegment;
use Illuminate\Support\Str;

class BusinessSegmentSeeder extends Seeder
{
    public function run(): void
    {
        $segments = [
            ['name' => 'Food Service', 'behavior_base' => 'food_service'],
            ['name' => 'Varejo', 'behavior_base' => 'retail'],
            ['name' => 'Serviços', 'behavior_base' => 'service'],
            ['name' => 'Indústria', 'behavior_base' => 'industry'],
        ];

        foreach ($segments as $segment) {
            BusinessSegment::updateOrCreate(
                ['behavior_base' => $segment['behavior_base']],
                [
                    'name' => $segment['name'],
                    'slug' => Str::slug($segment['name']),
                    'is_active' => true
                ]
            );
        }
    }
}