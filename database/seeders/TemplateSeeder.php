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
                'body' => 'Informasi Banjir!! ketinggian pada level $level, jarak anda dengan titik alat adalah $distance km dari unit  $ews_name cek web awasbencana.website untuk informasi lebih lanjut'
            ],
            [
                'disaster_id' => 2,
                'body' => 'Gempa pada koordinat $longitude, $latitude pada kedalaman $depth  kekuatan sebesar $strength  SR. Jarak anda dengan lokasi gempa adalah $distance km'
            ],
            [
                'disaster_id' => 3,
                'body' => 'Cuaca di tempat anda adalah $cuaca dengan suhu  $temp °C terasa seperti $feels_like °C pada tanggal $dt_txt'
            ],
        ];

        Template::insert($data);
    }
}
