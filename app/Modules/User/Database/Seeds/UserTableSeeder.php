<?php namespace App\Modules\User\Database\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    protected $table = 'users';

    public function run()
    {
        $faker = Factory::create();

        $this->call('App\Modules\User\Database\Seeds\GroupTableSeeder');

        // Delete all items
        DB::table($this->table)->truncate();

        DB::table($this->table)->insert([
            'name' => 'admin',
            'email' => 'admin@fcbafirma.rs',
            'first_name' => 'Admin',
            'last_name' => 'Last name',
            'password' => bcrypt('fcb1234'),
            'group_id' => 1,
            'status' => 1,
            'remember_token' => str_random(10),
            'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
        ]);

        DB::table($this->table)->insert([
            'name' => 'moderator',
            'email' => 'moderator@fcbafirma.rs',
            'first_name' => 'Moderator',
            'last_name' => 'Last name',
            'password' => bcrypt('fcb1234'),
            'group_id' => 2,
            'status' => 1,
            'remember_token' => str_random(10),
            'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
        ]);

        DB::table($this->table)->insert([
            'name' => 'user',
            'email' => 'user@fcbafirma.rs',
            'first_name' => 'User',
            'last_name' => 'Last name',
            'password' => bcrypt('user1234'),
            'group_id' => 3,
            'status' => 1,
            'remember_token' => str_random(10),
            'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
        ]);

        DB::table($this->table)->insert([
            'name' => 'rasplinjac',
            'email' => 'rasplinjac@gmail.com',
            'first_name' => 'Rasplinjac',
            'last_name' => 'Last name',
            'password' => bcrypt('fcb1234'),
            'group_id' => 1,
            'status' => 1,
            'remember_token' => str_random(10),
            'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
        ]);

    }
}