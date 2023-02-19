<?php

namespace Database\Seeders;

use App\Models\KategoryArticle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoryArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategory = [
            [
                'name' => 'Bencana'
            ],
            [
                'name' => 'Berita'
            ],
            [
                'name' => 'Info instansi'
            ],
        ];

        KategoryArticle::insert($kategory);
    }
}
