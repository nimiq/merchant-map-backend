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

        // Seed database with supported currencies
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

        // Seed database with issue categories
        $categories = [
            'Place closed',
            'Currency missing',
            'Currency not accepted',
            'Place doesn\'t accept crypto',
            'Other'
        ];

        foreach ($categories as $label) {
            \App\Models\IssueCategory::create([
                'label' => $label
            ]);
        }
    }
}
