<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageTableSeeder extends Seeder {

    protected $table = 'pages';

    public function run()
    {
        $faker = Factory::create();
        $items = array();

        // Create 100 items
        for ($i = 0; $i < 100; $i++) {

            $title =  $faker->sentence(rand(1,5));
            array_push($items, array(

                'title' => $title,
                'slug' => Str::slug($title),

                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),

            ));
        }

        // Delete all items
        DB::table($this->table)->truncate();
        DB::table($this->table)->insert($items);
    }
}