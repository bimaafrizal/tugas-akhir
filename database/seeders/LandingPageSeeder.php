<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LandingPage::create([
            'title' => 'Promote Your App with SoftLand',
            'subtitle' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit.",
            'title_about1' => 'Seamlessly Communicate',
            'about1' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur at reprehenderit optio, laudantium eius quod, eum maxime molestiae porro omnis. Dolores aspernatur delectus impedit incidunt dolore mollitia esse natus beatae.",
            'title_about2' => 'Gather Feedback',
            'about2' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur at reprehenderit optio, laudantium eius quod, eum maxime molestiae porro omnis. Dolores aspernatur delectus impedit incidunt dolore mollitia esse natus beatae.",
            'footer' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus pariatur, numquam aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae deleniti minus animi.",
        ]);
    }
}
