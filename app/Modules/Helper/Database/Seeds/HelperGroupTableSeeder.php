<?php namespace App\Modules\Helper\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Modules\Helper\Models\HelperGroup;

class HelperGroupTableSeeder extends Seeder {

    protected $table = 'helper_groups';

    public function run()
    {
        $faker = Factory::create();
        $items = array();

        $numberOfItems = 10;

        for ($i = 0; $i < $numberOfItems; $i++) {

            $title = $faker->word(2);

            array_push($items, array(
                'title' => $title,
                'slug' => str_slug($title),
                'intro' => $faker->sentence(7),
                'description' => $faker->sentence(15),
                'status' => $faker->randomElement(array(1, 1, 1, 0, 1)),

                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),

            ));
        }

        // Delete all items
        DB::table($this->table)->truncate();
        DB::table($this->table)->insert($items);

//        HelperGroup::rebuild();
    }
}