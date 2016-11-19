<?php

use Illuminate\Database\Seeder;

class ArrowsTableSeeder extends Seeder
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

            \App\Arrow::create([
                'pair_id' => $pair_id->id,
                'm5_color' => $faker->randomElement(['255', '32768', '65535']),
                'm15_color' => $faker->randomElement(['255', '32768', '65535']),
                'h1_color' => $faker->randomElement(['255', '32768', '65535']),
                'lts_color' => $faker->randomElement(['255', '32768', '65535']),
                'hts_color' => $faker->randomElement(['255', '32768', '65535']),
                'ts_color' => $faker->randomElement(['255', '32768', '65535']),
                'ts_direction' => $faker->randomElement(['DOWN', 'UP', 'RIGHT', 'RIGHT_UP', 'RIGHT_DOWN']),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }

    }
}
