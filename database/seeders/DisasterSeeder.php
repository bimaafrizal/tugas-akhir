<?php

namespace Database\Seeders;

use App\Models\Disaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Disaster::create([
            'name' => 'Banjir',
            'distance' => 70,
        ]);

        Disaster::create([
            'name' => 'Gempa',
            'strength' => 5,
            'distance' => 70,
            'depth' => 100
        ]);
    }
}
