<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;
use Illuminate\Support\Facades\Http;

class CountryFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Country::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        $client = json_decode(Http::get('http://country.io/names.json'));
        foreach($client as $key=>$data){
            $country[]=[$key,$data];
            //$alpha_2_code[] = $key;
            //$countries[] = $data;
        }
        $rnd = rand(0, count($country) - 1);
        return [
            'name' => $country[$rnd][1],
            'alpha_2_code' => $country[$rnd][0],
        ];
    }
}
