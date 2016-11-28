<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = ['Cater' => '38651609658', 'Luka' => '38640555922', 'Marko' => '38641807670'];

        foreach ($users as $value => $key) {
            User::create([
                'name' => $value,
                'email' => $faker->email,
                'password' => bcrypt('Geslo123'),
                'phone_num' => $key,
                'active_sms' => $faker->boolean(50),
                'remember_token' => str_random(10),
            ]);
        }

    }
}
