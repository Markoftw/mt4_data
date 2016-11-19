<?php

use Illuminate\Database\Seeder;

class PricesTableSeeder extends Seeder
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

            $pair_id = \App\Pair::where('pair', $pair)->select('id')->first();

            \App\Price::create([
                'pair_id' => $pair_id->id,
                'bid_price' => $faker->randomFloat(null, 0, 120),
                'period_m5' => $faker->randomFloat(null, 0, 120),
                'period_m15' => $faker->randomFloat(null, 0, 120),
                'period_m30' => $faker->randomFloat(null, 0, 120),
                'period_h1' => $faker->randomFloat(null, 0, 120),
                'm5_up' => $faker->randomElement(['1.046442857143205', '2147483647']),
                'm15_up' => $faker->randomElement(['1.046442857143205', '2147483647']),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
