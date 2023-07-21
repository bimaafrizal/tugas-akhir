<?php

namespace Database\Seeders;

use App\Models\StandardEws;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StandardEwsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StandardEws::create([
            'name' => 'Belum Standar(1 field(0-4096)/3 field/6 field)'
        ]);
        StandardEws::create([
            'name' => 'Standar(1 field(0-3))'
        ]);
    }
}