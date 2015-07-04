<?php namespace App\Modules\Work\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkTableSeeder extends Seeder {

    protected $table = 'works';

    public function run()
    {
        $faker = Factory::create();
        $items = array();

        // Create 100 items
        for ($i = 0; $i < 100; $i++) {

            array_push($items, array(

                'title' => $faker->word(2),
                'sub_title' => $faker->word(3),
                'slug' => $faker->word(4),
                'intro' => $faker->sentence(4),
                'description' => $faker->sentence(8),

                'lang' => 'sr',
                'trans_id' => 0,

                'order' => $faker->randomDigitNotNull(),
                'featured' => $faker->randomElement(array(1, 1, 1, 0, 1, 0, 0)),
                'status' => $faker->randomElement(array(1, 1, 1, 0, 1, 0, 0)),

                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),

            ));
        }

        // Delete all items
        DB::table($this->table)->truncate();
        DB::table($this->table)->insert($items);
    }
}