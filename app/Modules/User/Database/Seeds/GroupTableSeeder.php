<?php namespace App\Modules\User\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupTableSeeder extends Seeder
{
    protected $table = 'groups';

    public function run()
    {
        $faker = Factory::create();

        // Delete all items
        DB::table($this->table)->truncate();

        DB::table($this->table)->insert([
            'name' => 'Administrator',
            'status' => 1,
            'admin' => 1,
            'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
        ]);

        DB::table($this->table)->insert([
            'name' => 'Moderator',
            'status' => 1,
            'admin' => 1,
            'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
        ]);

        DB::table($this->table)->insert([
            'name' => 'User',
            'status' => 1,
            'admin' => 0,
            'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
        ]);
    }
}