<?php

use Illuminate\Database\Seeder;

class PairsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Pair::class, 26)->create();

        $pairs = array("AUDCAD", "AUDCHF", "AUDJPY", "AUDNZD", "AUDUSD", "CADCHF", "CADJPY", "CHFJPY", "EURAUD", "EURCAD",
            "EURCHF", "EURGBP", "EURJPY", "EURNZD", "EURUSD", "GBPAUD", "GBPCAD", "GBPCHF", "GBPJPY", "GBPNZD",
            "GBPUSD", "NZDJPY", "NZDUSD", "USDCAD", "USDCHF", "USDJPY");

        foreach ($pairs as $pair) {
            App\Pair::create([
                'pair' => $pair
            ]);
        }

    }
}
