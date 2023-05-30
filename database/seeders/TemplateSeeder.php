<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'disaster_id' => 1,
                'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem iste numquam ad molestias odit iusto vero modi repellendus at culpa.'
            ],
            [
                'disaster_id' => 2,
                'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem iste numquam ad molestias odit iusto vero modi repellendus at culpa.'
            ],
            [
                'disaster_id' => 3,
                'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem iste numquam ad molestias odit iusto vero modi repellendus at culpa.'
            ],
        ];

        Template::insert($data);
    }
}
