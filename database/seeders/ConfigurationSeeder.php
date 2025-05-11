<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = new Configuration();
        $config->key = 'commission_pct';
        $config->value = '0.085';
        $config->description = 'The commission percentage for the sale.';
        $config->save();
    }
}
