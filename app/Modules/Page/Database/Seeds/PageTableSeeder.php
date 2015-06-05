<?php namespace App\Modules\Page\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder {

    protected $table = 'pages';

    public function run()
    {
        $faker = Factory::create();
        $items = array();

        // Create 100 items
        for ($i = 0; $i < 100; $i++) {

            array_push($items, array(

                'title' => $faker->sentence(4),
                'slug' => $faker->sentence(4),

                'status' => $faker->randomElement(array(1, 1, 1, -1, -1, 0, 0)),

                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),

            ));
        }

        // Delete all items
        DB::table($this->table)->truncate();
        DB::table($this->table)->insert($items);
    }
}