<?php

use Illuminate\Database\Seeder;

class CStrengthsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        \App\CStrength::create([
            'usd_now' => $faker->randomFloat(null, 0, 1),
            'usd_then' => $faker->randomFloat(null, 0, 1),
            'eur_now' => $faker->randomFloat(null, 0, 1),
            'eur_then' => $faker->randomFloat(null, 0, 1),
            'gbp_now' => $faker->randomFloat(null, 0, 1),
            'gbp_then' => $faker->randomFloat(null, 0, 1),
            'chf_now' => $faker->randomFloat(null, 0, 1),
            'chf_then' => $faker->randomFloat(null, 0, 1),
            'jpy_now' => $faker->randomFloat(null, 0, 1),
            'jpy_then' => $faker->randomFloat(null, 0, 1),
            'aud_now' => $faker->randomFloat(null, 0, 1),
            'aud_then' => $faker->randomFloat(null, 0, 1),
            'cad_now' => $faker->randomFloat(null, 0, 1),
            'cad_then' => $faker->randomFloat(null, 0, 1),
            'nzd_now' => $faker->randomFloat(null, 0, 1),
            'nzd_then' => $faker->randomFloat(null, 0, 1),
            'mkt' => $faker->randomFloat(null, 0, 1),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

    }
}
