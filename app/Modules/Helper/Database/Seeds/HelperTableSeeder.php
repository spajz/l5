<?php namespace App\Modules\Client\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTableSeeder extends Seeder {

    protected $table = 'helpers';

    public function run()
    {
        $faker = Factory::create();
        $items = array();

        // Create 100 items
//        for ($i = 0; $i < 100; $i++) {
//
//            array_push($items, array(
//
//                'title' => $faker->word(2),
//                'slug' => $faker->word(4),
//                'description' => $faker->sentence(8),
//                'industry' => $faker->word(2),
//
//                'order' => $faker->randomDigitNotNull(),
//                'featured' => $faker->randomElement(array(1, 1, 1, 0, 1, 0, 0)),
//                'status' => $faker->randomElement(array(1, 1, 1, 0, 1, 0, 0)),
//
//                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
//                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
//
//            ));
//        }

        // Delete all items
        DB::table($this->table)->truncate();
        DB::table($this->table)->insert($items);
    }
}