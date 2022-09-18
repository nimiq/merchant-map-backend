<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create();

        $currencies = [
            'Bitcoin' => 'BTC',
            'Dash' => 'DASH',
            'Litecoin' => 'LTC',
            'Ethereum' => 'ETH',
            'Ripple' => 'XRP',
            'Stellar' => 'XLM',
            'Nimiq' => 'NIM'
        ];

        foreach ($currencies as $name => $symbol) {
            \App\Models\Currency::create([
                'name' => $name,
                'symbol' => $symbol
            ]);
        }
    }
}
