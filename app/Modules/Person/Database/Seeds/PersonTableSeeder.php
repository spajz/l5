<?php namespace App\Modules\Person\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonTableSeeder extends Seeder {

    protected $table = 'persons';

    public function run()
    {
        $faker = Factory::create();
        $items = array();

        // Create 100 items
        for ($i = 0; $i < 100; $i++) {

            array_push($items, array(

                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'job_title' => $faker->sentence(2),
//                'description' => $faker->sentence(4),

//                'lang' => 'sr',
//                'trans_id' => 0,

                'order' => $faker->randomDigitNotNull(),
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