<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TimeoutCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timeout:cron';
    protected static $usd_to_myr = -1;
    protected static $realtime_curr_list = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* Log::info("Cron is working fine!");
        return; */
        /* self::getRealTime();
        $available_curr = Currency::get('name');
        foreach ($available_curr as $key => $value) {
            Log::info(self::convertBasedOnMYR($value));
        } */
        //Log::info(Currency::get('name'));
        //dd('hi');
    }

    /* function getRealTime()
    {
        $response = Http::withHeaders(
            [
                'X-RapidAPI-Key' => 'e048c447eemsh6d3d83643dbb2b0p1ed171jsn66126b55cb3f',
                'X-RapidAPI-Host' => 'currencyscoop.p.rapidapi.com',
            ]
        )->get('https://currencyscoop.p.rapidapi.com/latest');
                
        //renew at 6am
        self::$usd_to_myr = $response['response']['rates']['MYR'];
        self::$realtime_curr_list = ($response['response']['rates']);
    }

    function convertBasedOnMYR($result_curr_name)
    {
        $usd_to_curr = self::$usd_to_myr;
        $bresult_curr = self::$realtime_curr_list[$result_curr_name];
        $result_curr =  $bresult_curr / $usd_to_curr;
        return $result_curr;
    } */
}
