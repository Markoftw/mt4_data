<?php

use Illuminate\Database\Seeder;

class HistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s', strtotime('-1 hour'));
        //for($i = 0; $i < 10; $i++) {
            App\History::create([
                'pair_id' => 15,
                'order_type' => 'NONE',
                'bid_price' => '0.00000',
                'rating' => 'rate',
                'created_at' => $date
            ]);
        //}
    }
}
