<?php

use Illuminate\Database\Seeder;

class SignalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $pairs = array("AUDCAD", "AUDCHF", "AUDJPY", "AUDNZD", "AUDUSD", "CADCHF", "CADJPY", "CHFJPY", "EURAUD", "EURCAD",
            "EURCHF", "EURGBP", "EURJPY", "EURNZD", "EURUSD", "GBPAUD", "GBPCAD", "GBPCHF", "GBPJPY", "GBPNZD",
            "GBPUSD", "NZDJPY", "NZDUSD", "USDCAD", "USDCHF", "USDJPY");

        foreach ($pairs as $pair) {
            DB::table('signals')->insert([
                'para' => $pair,
                'cs_signal' => $faker->randomElement(['NO', 'SELL', 'BUY']),
                'p_m5' => $faker->randomElement(['NO', 'SELL', 'BUY']),
                'p_m15' => $faker->randomElement(['NO', 'SELL', 'BUY']),
                'p_m30' => $faker->randomElement(['NO', 'SELL', 'BUY']),
                'p_h1' => $faker->randomElement(['NO', 'SELL', 'BUY']),
                'TD_m5' => $faker->randomElement(['NEUTRAL', 'SELL', 'BUY']),
                'TD_m15' => $faker->randomElement(['NEUTRAL', 'SELL', 'BUY']),
                'TD_h1' => $faker->randomElement(['NEUTRAL', 'SELL', 'BUY']),
                'TD_LTS' => $faker->randomElement(['NEUTRAL', 'SELL', 'BUY']),
                'TD_HTS' => $faker->randomElement(['NEUTRAL', 'SELL', 'BUY']),
                'TD_TS' => $faker->randomElement(['NEUTRAL', 'SELL', 'BUY']),
                'EVO_5' => $faker->randomElement(['SELL', 'BUY']),
                'EVO_15' => $faker->randomElement(['SELL', 'BUY']),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
