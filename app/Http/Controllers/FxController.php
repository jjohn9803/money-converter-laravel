<?php

namespace App\Http\Controllers;

use App\Models\Fx;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($base_id, $result_id)
    {
        return Fx::where('base_currency_id', '=', $base_id)->where('result_currency_id', '=', $result_id)->orderBy('updated_at', 'desc')->first();
    }

    /* public function fx_rate($base_id,$result_id)
    {
        return Fx::where('base_currency_id','=',$base_id)->where('result_currency_id','=',$result_id)->orderBy('updated_at','desc')->first('fx_rate');
    } */

    public function fx_rate(Request $request)
    {
        return Fx::where('base_currency_id', '=', $request->base_id)->where('result_currency_id', '=', $request->result_id)->orderBy('updated_at', 'desc')->first('fx_rate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fx  $fx
     * @return \Illuminate\Http\Response
     */
    public function show(Fx $fx)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fx  $fx
     * @return \Illuminate\Http\Response
     */
    public function edit(Fx $fx)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fx  $fx
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fx $fx)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fx  $fx
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fx $fx)
    {
        //
    }

    public function getRealtimeFxes(Request $request)
    {
        if (!request()->ajax()) {
            return abort(404);
        }
        $num_dates = $request->num_dates;
        $currency_code = $request->currency_code;
        //Session 1 generate top * date that available
        $count_date = 0;
        $session = ['1700'];
        /* $session = ['0900', '1130', '1200', '1700']; */
        $date = Carbon::now();
        $quote = 'rm';
        $result = [];
        while ($count_date < $num_dates) {
            $valid = true;
            $array_temp = [];
            foreach ($session as $key => $value) {
                $url = 'https://api.bnm.gov.my/public/exchange-rate/' . $currency_code . "/date/" . $date->format('Y-m-d') . '?session=' . $value . '&quote=' . $quote;
                $response = Http::withHeaders(
                    [
                        'Accept' => 'application/vnd.BNM.API.v1+json',
                    ]
                )->get($url);
                if ($response->status() == '404') {
                    $valid = false;
                    break;
                } else {
                    $array_temp[$value] = $response['data'];
                }
            }
            if ($valid) {
                array_push($result, $array_temp);
                $count_date += 1;
            }
            $date = $date->subDays(1);
        }
        //Session 2 get top 10 available date
        $final_result = [];
        $our_result = [];
        foreach ($result as $key => $value) {
            $result_temp = [];
            $result_temp['date'] = $value['1700']['rate']['date'];
            $our_result[$key]['date'] = $value['1700']['rate']['date'];
            $result_temp['unit'] = $value['1700']['unit'];
            foreach ($value as $key2 => $session) {
                $result_temp['rate'] = $session['rate']['selling_rate'];
                $our_result[$key]['rate'] = $session['rate']['selling_rate'] * (1 + (rand(1, 500) / 1000000));
                //$result_temp[$key2] = $session['rate']['selling_rate'];
            }
            krsort($result_temp);
            array_push($final_result, $result_temp);
        }
        array_multisort(array_column($final_result, 'date'), SORT_ASC, $final_result);
        array_multisort(array_column($our_result, 'date'), SORT_ASC, $our_result);
        return [$final_result, $our_result];
    }
}
