<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ArrowsTableSeeder::class);
        $this->call(DataTableSeeder::class);
        $this->call(PriceTableSeeder::class);
        $this->call(SignalsTableSeeder::class);
    }
}
