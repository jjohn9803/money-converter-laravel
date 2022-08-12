<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(resource_path().'\api\malaysia_banks.json');
        $countries = json_decode($json,true);
        foreach ($countries as $value) {
            Bank::create([
                "name" => $value['name'],
                "country_id" => 11,
            ]);
        }

        //Bank::factory()->count(10)->create();
    }
}
