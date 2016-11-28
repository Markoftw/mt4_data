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
        $this->call(UsersTableSeeder::class);
        $this->call(PairsTableSeeder::class);
        $this->call(ArrowsTableSeeder::class);
        $this->call(DataTableSeeder::class);
        $this->call(PricesTableSeeder::class);
        $this->call(SignalsTableSeeder::class);
        $this->call(CStrengthsTableSeed::class);
        $this->call(HistoryTableSeeder::class);
    }
}
