<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Fx;
use App\Models\Notification;
use App\Models\Reason;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function getRealTime()
    {
        $response1 = Http::withHeaders(
            [
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )->post('https://ob.nordigen.com/api/v2/token/new/', [
            'secret_id' => '02901f74-2f5f-4d1c-a4c9-26c162629e5b',
            'secret_key' => 'c729da25275b7a46f9c6adeb8729909a4bcc778edb3d664747f956741aea00a7997f7a25a09f8dd0b174b8eddc3a361fc0611aabd03abf212636329837cb797c'
        ]);
        $token = $response1['access'];
        $response = Http::withHeaders(
            [
                'accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        )->get('https://ob.nordigen.com/api/v2/institutions/?country=my');

        return $response;
        self::$usd_to_myr = $response['response']['rates']['MYR'];
        self::$realtime_curr_list = ($response['response']['rates']);
    }

    public function index()
    {
        return Notification::with(['transasction'])
                //->join('user', 'user.id', 'notifications.user_id')
                ->with(['reason'])
                ->where('notifications.user_id', '=', Auth::user()->id);
        $v = \Faker\Factory::create()->unixTime($max = 'now');
        $re = 'hey';
        while (Transaction::where('ref_no', '=', $v)->exists()) {
            $v = \Faker\Factory::create()->unixTime($max = 'now');
            $re = 'nn';
        }
        return $re;
        return Transaction::where('ref_no', '=', $v)->exists();
        while (Transaction::find('ref_no', '=', $v)) {
            # code...
        }
        return \Faker\Factory::create()->unixTime($max = 'now');
        return self::getRealTime();
        return Transaction::all()->count();
        $canvasTransactions = Transaction::select(
            DB::raw("(count(id)) as total_count"),
            DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as my_date")
        )
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->where('status', 4)
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
            ->get();
        return $canvasTransactions;
        return Transaction::whereDate('created_at', Carbon::now())->get();
        $latestFx = Fx::whereIn('id', Fx::select(DB::raw('MAX(id)'))->groupBy(['result_currency_id'])->pluck('MAX(id)'))->get()->toArray();
        /* var_dump($latestFx->meta_data->{"First name"}->value);
        return $latestFx; */
        return array_search(3, array_column($latestFx, 'result_currency_id'));
        $a = Transaction::with('to_curr')->selectRaw('to_curr_id,COUNT(*) as order_count')
            ->groupBy('to_curr_id')
            ->orderByRaw('COUNT(*) DESC')
            ->first();
        return $a;
        return User::whereDate('email_verified_at', '=', Carbon::yesterday())->count();
        return Transaction::find(2);
        return Transaction::where('id', Crypt::decrypt('eyJpdiI6Ikh0cllXY21tYVFOZll0YzBJMTJkRWc9PSIsInZhbHVlIjoiTHQ0UnJyemV3bE1WeGpvZXp4SVg5Zz09IiwibWFjIjoiN2FlNjUxOTM1OTllMTA1ZmVhMGQ4NDEzNDE0M2I2ZmMwODczMWMzMDBlMzEzNjBhYmRjNzU1ZWE1MzYwYWQ0MSIsInRhZyI6IiJ9'))->first()->ref_no;
        $transaction = Transaction::join('banks as banks', 'transactions.from_bank', 'banks.id')
            ->join('banks as receive_banks', 'transactions.your_receive_bank', 'receive_banks.id')
            ->join('bank_accounts', 'transactions.to_acc_id', 'bank_accounts.id')
            ->join('banks as to_bank', 'bank_accounts.bank_id', 'to_bank.id')
            ->join('currencies as from_curr', 'transactions.from_curr_id', 'from_curr.id')
            ->join('currencies as to_curr', 'transactions.to_curr_id', 'to_curr.id')
            ->where('transactions.user_id', '=', Auth::user()->id)
            ->select(
                'transactions.*',
                'banks.name as from_bank_name',
                'receive_banks.name as your_receive_bank',
                'bank_accounts.account_no as to_acc',
                'to_bank.name as to_acc_name',
                'from_curr.name as from_curr_name',
                'to_curr.name as to_curr_name'
            );
        $transaction = $transaction->get();
        //return $transaction;
        foreach ($transaction as $key => $value) {
            $transaction[$key]['new_id'] = Crypt::encryptString($transaction[$key]['id']);
            unset($transaction[$key]['id']);
        }
        return $transaction;
        //return $str;
        return Transaction::join('banks as banks', 'transactions.from_bank', 'banks.id')
            ->join('banks as receive_banks', 'transactions.your_receive_bank', 'receive_banks.id')
            ->join('bank_accounts', 'transactions.to_acc_id', 'bank_accounts.id')
            ->join('banks as to_bank', 'bank_accounts.bank_id', 'to_bank.id')
            ->join('currencies as from_curr', 'transactions.from_curr_id', 'from_curr.id')
            ->join('currencies as to_curr', 'transactions.to_curr_id', 'to_curr.id')
            ->where('transactions.user_id', '=', Auth::user()->id)
            ->where('transactions.id', '=', Crypt::decrypt("eyJpdiI6IjM1UlhINmhNN0NFc2trVkd2clc2a2c9PSIsInZhbHVlIjoiMVJDcXd1STNraUZoRng1WTJFcnl5UT09IiwibWFjIjoiOGI5OTk2ZDgyN2UyYWVlNWNiZTU2ODg2NWNjYzg0MTVjM2JjYjU4ZTdlMDM4MDgyNjQ3MjkxZTc5YmQ3ZTAxNyIsInRhZyI6IiJ9"))
            ->select(
                'transactions.*',
                'banks.name as from_bank_name',
                'receive_banks.name as your_receive_bank',
                'bank_accounts.account_no as to_acc',
                'to_bank.name as to_acc_name',
                'from_curr.name as from_curr_name',
                'to_curr.name as to_curr_name'
            )
            ->first();
        return Reason::get('message');
        return Notification::where('user_id', '=', Auth::user()->id)->where('status', '=', '1')->get();
        /* $notification = Notification::with(['transasction','reason'])
        //->join('user', 'user.id', 'notifications.user_id')
        ->get(); */
        $notification = Notification::with(['transasction'])
            //->join('user', 'user.id', 'notifications.user_id')
            ->with(['reason'])
            ->where('notifications.user_id', '=', Auth::user()->id)->where('status', '1');
        /* if ($request->read_filter == 2) {
            $notification = $notification->where('status', '=', '1');
        } else if ($request->read_filter == 3) {
            $notification = $notification->where('status', '=', '2');
        }
        if ($request->order == 2) {
            $notification = $notification->orderBy('created_at', 'asc');
        } else {
            $notification = $notification->orderBy('created_at', 'desc');
        } */
        $notification = $notification->get();
        return $notification;
        return Notification::where('user_id', '=', Auth::user()->id)->where('status', '=', '1')->get();
        return Reason::all();
        return User::where('email', 'b200046a@sc.edu.com')->count();
        //->whereColumn('max_amt','>','min_amt')
        return Currency::with('country')->whereColumn('max_amt', '>', 'min_amt')->where('min_amt', '>=', '0')->get();
        $faker = \Faker\Factory::create();
        return $faker->numberBetween($min = 1000000000000, $max = 9999999999999);
        return Notification::join('transactions', 'transactions.id', 'notifications.transasction_id')->select(
            'notifications.*',
            'transactions.id as transaction_id',
            'transactions.status as transaction_status',
            'transactions.user_id as user_id'
        )->where('user_id', '=', Auth::user()->id)->find(110);
        return $notification = Notification::join('transactions', 'transactions.id', 'notifications.transasction_id')->select(
            'notifications.*',
            'transactions.status as transaction_status'
        )->orderBy('created_at', 'desc')->get();
        return $notification = Notification::whereHas('transasction', function ($query) {
            $query->where('user_id', '=', Auth::user()->id);
        })->where('status', '=', '1')->get();
        $table = Transaction::where('status', '=', 2)->get();
        $new_table = [];
        $count = $table->count();
        //        return $count;
        // 处理逻辑
        $getCount = session()->get('count');
        foreach ($table as $key => $value) {
            /* Log::debug($value);
            Log::debug(session()->get('new_transactions.' . $key)); */
            if ($key == session()->get('new_transactions.' . (string)$key)) {
                return $key . ' is repeated!';
                //array_push($new_table, $value);
                //$new_table[$key] = $value;
            } else {
                session()->put('new_transactions' . $key, $key);
                return $key . ' is welcomed!';
                //return ['code' => 200, 'msg' => 'New Order has arrived!', 're' => $count];
            }
        }
        return;
        //return session()->get('count');
        return gettype(Transaction::where('status', '=', 2)->count());
        $transaction = Transaction::join('banks as banks', 'transactions.from_bank', 'banks.id')
            ->join('banks as receive_banks', 'transactions.your_receive_bank', 'receive_banks.id')
            ->join('bank_accounts', 'transactions.to_acc_id', 'bank_accounts.id')
            ->join('banks as to_bank', 'bank_accounts.bank_id', 'to_bank.id')
            ->join('currencies as from_curr', 'transactions.from_curr_id', 'from_curr.id')
            ->join('currencies as to_curr', 'transactions.to_curr_id', 'to_curr.id')
            ->where('transactions.user_id', '=', Auth::user()->id)
            ->select(
                'transactions.*',
                'banks.name as from_bank_name',
                'receive_banks.name as your_receive_bank',
                'bank_accounts.account_no as to_acc',
                'to_bank.name as to_acc_name',
                'from_curr.name as from_curr_name',
                'to_curr.name as to_curr_name'
            )
            ->orderBy('transactions.created_at', 'desc')
            ->first();
        $id = Crypt::encrypt($transaction->id);
        echo ($id);
        echo (Crypt::decrypt($id));
        return;
        /* return $transaction = Transaction::join('banks as banks', 'transactions.from_bank', 'banks.id')
        ->join('banks as receive_banks', 'transactions.your_receive_bank', 'receive_banks.id')
        ->join('bank_accounts', 'transactions.to_acc_id', 'bank_accounts.id')
        ->join('banks as to_bank', 'bank_accounts.bank_id', 'to_bank.id')
        ->join('currencies as from_curr', 'transactions.from_curr_id', 'from_curr.id')
        ->join('currencies as to_curr', 'transactions.to_curr_id', 'to_curr.id')
        ->where('transactions.user_id', '=', Auth::user()->id)
        ->select(
            'transactions.*',
            'banks.name as from_bank_name',
            'receive_banks.name as your_receive_bank',
            'bank_accounts.account_no as to_acc',
            'to_bank.name as to_acc_name',
            'from_curr.name as from_curr_name',
            'to_curr.name as to_curr_name'
        )
        ->orderBy('transactions.created_at','desc')
        ->get(); */
        return Notification::has('transasction')->get();
        return Notification::whereHas('transasction', function ($q) {
            $q->where('transactions.id', '=', 'notifications.transasction_id');
        })->get();
        return Notification::where(function ($query) {

            if (!empty($request->class_id)) {
                $query->where('class_id', $request->class_id);
            }

            if (!empty($request->section_id)) {
                $query->where('section_id', $request->section_id);
            }
        })->get();
        return Notification::whereHas('transasction', function ($q) {
            $q->where('notifications.transasction_id', '=', 'transasction.id');
        })->get();
        /* $arr1 = array(
            array('id'=>1,'name'=>'aA','cat'=>'cc'),
            array('id'=>2,'name'=>'aa','cat'=>'dd'),
            array('id'=>3,'name'=>'bb','cat'=>'cc'),
            array('id'=>4,'name'=>'bb','cat'=>'dd')
        );
        
        $arr2 = array_msort($arr1, array('name'=>SORT_DESC, 'cat'=>SORT_ASC));
        return $arr2; */
        $str = 'bitch';
        $str2 = 'cat';
        //return strcmp($str2, $str);
        $array = Fx::whereIn('fxes.id', Fx::select(DB::raw('MAX(id)'))->groupBy(['result_currency_id'])
            ->pluck('MAX(id)')->toArray())->with('result_currency')->get();

        return collect($array)->sortBy('result_currency.name')->toArray();

        return $this->multi_sort($array, $key = 'name');

        //return $array;
        foreach ($array as $key => $row) {
            $result_currency[$key]  = [$key, $row['result_currency']];
        }
        /* foreach ($result_currency as $key => $row) {
            $sort_result_currency[$key]  = [$key, $row['result_currency']];
        } */
        /* return array_multisort('name'=>SORT_DESC, SORT_DESC, $edition, SORT_ASC, $data); */
        $new_array = [];
        foreach ($array as $key => $value) {
            if (count($new_array) == -1) {
            }
            array_push($new_array, $array[$lowest]['result_currency']['name']);
            /* $lowest = -1;
            for ($i = 0; $i < count($array); $i++) {
                $cval = $value['result_currency']['name'];
                if ($lowest == -1) {
                    $lowest == $i;
                } else {
                    $lowestVal = $array[$lowest]['result_currency']['name'];
                    if ((in_array($cval, $new_array, FALSE)) && (!strcmp($lowestVal, $cval))) {
                        $lowest == $i;
                    }
                }
            }
            array_push($new_array, $array[$lowest]['result_currency']['name']); */
            //echo ($value['result_currency']);
        }
        return;
        $result = null;
        /* for ($i = 0; $i < count($array); $i++) {
            $lowest = -1;
            for ($j = 0; $j < count($array); $j++) {
                $val = $array[$j]['result_currency']['name'];
                if ($lowest == -1) {
                    $lowest == $j;
                } else {
                    $lowestVal = $array[$lowest]['result_currency']['name'];
                    if ((in_array($val, $new_array, FALSE)) || ($val < $lowestVal)) {
                        $lowest == $j;
                    }
                }
            }
            array_push($new_array, $array[$lowest]['result_currency']['name']);
        } */

        return $result;

        /* return usort($array, function($a, $b) {
            return $a['name'] <=> $b['name'];
        }); */
        return str_pad('69', 5, '0', STR_PAD_LEFT);
        $response = Http::withHeaders(
            [
                'X-RapidAPI-Key' => 'e048c447eemsh6d3d83643dbb2b0p1ed171jsn66126b55cb3f',
                'X-RapidAPI-Host' => 'currencyscoop.p.rapidapi.com',
            ]
        )->get('https://currencyscoop.p.rapidapi.com/latest');
        /* if($response->failed()){
            throw new RuntimeException('Failed!',$response->status());
        } */
        return $response['response'];
        //return phpinfo();
        $client = new Client(array(
            'base_uri' => 'https://hacker-news.firebaseio.com'
        ));
        //$client->setSslVerification(false);

        $endpoints = array(
            'top' => '/v0/topstories.json',
            'ask' => '/v0/askstories.json',
            'job' => '/v0/jobstories.json',
            'show' => '/v0/showstories.json',
            'new' => '/v0/newstories.json'
        );

        foreach ($endpoints as $type => $endpoint) {

            $response = $client->get($endpoint);
            $result = $response->getBody();

            $items = json_decode($result, true);

            foreach ($items as $id) {
                $item_res = $client->get("/v0/item/" . $id . ".json");
                $item_data = json_decode($item_res->getBody(), true);

                if (!empty($item_data)) {

                    $item = array(
                        'id' => $id,
                        'title' => $item_data['title'],
                        'item_type' => $item_data['type'],
                        'username' => $item_data['by'],
                        'score' => $item_data['score'],
                        'time_stamp' => $item_data['time'],
                    );

                    $item['is_' . $type] = true;

                    if (!empty($item_data['text'])) {
                        $item['description'] = strip_tags($item_data['text']);
                    }

                    if (!empty($item_data['url'])) {
                        $item['url'] = $item_data['url'];
                    }

                    $db_item = DB::table('items')
                        ->where('id', '=', $id)
                        ->first();

                    if (empty($db_item)) {

                        DB::table('items')->insert($item);
                    } else {

                        DB::table('items')->where('id', $id)
                            ->update($item);
                    }
                }
            }
        }
        return 'ok';

        $client = new Client();
        $client->setSslVerification(false);
        $res = $client->request('GET', 'https://community-hacker-news-v1.p.rapidapi.com/updates.json', []);
        return self::getClient()->send($res);
        /* dd($res->getStatusCode());
        return $res->getStatusCode(); */
        /* $request = new HttpRequest();
        $request->setUrl('https://community-hacker-news-v1.p.rapidapi.com/updates.json');
        $request->setMethod(HTTP_METH_GET); */

        $request = new Request;
        $request->setUrl('https://community-hacker-news-v1.p.rapidapi.com/updates.json');
        $request->setMethod('GET');

        $request->setQueryData([
            'print' => 'pretty'
        ]);

        $request->setHeaders([
            'X-RapidAPI-Key' => 'e048c447eemsh6d3d83643dbb2b0p1ed171jsn66126b55cb3f',
            'X-RapidAPI-Host' => 'community-hacker-news-v1.p.rapidapi.com'
        ]);

        try {
            $response = $request->send();

            echo $response->getBody();
        } catch (Exception $ex) {
            echo $ex;
        }
        return;
        return Transaction::whereHas('transasction', function ($query) {
            $query->where('transactions.user_id', '=', Auth::user()->id);
        })->find(62);
        return User::get('password');
        /* ->leftJoin('banks', function($join2) {
            $join2->on('transactions.to_bank_id', '=', 'banks.id');
          })->leftJoin('bank_accounts', function($join) {
            $join->on('transactions.from_acc', '=', 'bank_accounts.id');
          })->leftJoin('fxes', function($join) {
            $join->on('transactions.fx_id', '=', 'fxes.id');
          }) */
        return Notification::whereHas('transasction', function ($query) {
            $query->where('user_id', '=', 1);
        })->find(1);
        return Log::info("Cron is working fine!");
        return Transaction::get()->to_acc->account_no . ' (' . Transaction::get()->to_acc->bank->name . ')';;
        $faker = \Faker\Factory::create();
        return \Faker\Factory::create()->unixTime($max = 'now');
        return BankAccount::with('bank:id,name')->where('status', '=', 1)->get();

        return Fx::whereIn('id', Fx::select(DB::raw('MAX(id)'))->groupBy(['base_currency_id', 'result_currency_id'])->pluck('MAX(id)')->toArray())->get();
        $a = (new Transaction())::with('from_bank1:id,name')->with('to_bank:id,name')->get();

        //$a = (new Transaction())::leftJoin('from_bank1')->where('user_id',1)->orderBy('id','DESC')->get();
        return $a->from_bank1;
        //return User::where('id', 1)->orderBy('id','DESC')->take(10)->get();
        $get = Fx::with('base_currency')->with('result_currency')->get();
        foreach ($get as $p) {
            $result[] = $p->base_currency->name . " => " . $p->result_currency->name;
        }
        return $result;

        return $get->base_currency->name . " => " . $get->result_currency->name;
        //return Fx::all()->pluck('fx_rate','id');
        //$fx = Fx::whereIn('id',Fx::select(DB::raw('MAX(id)'))->groupBy(['base_currency_id','result_currency_id'])->pluck('MAX(id)')->toArray())->get();
        $base = 1;
        $result = 3;
        //return FX::where('base_currency_id', $base)->where('result_currency_id', $result)->where('id','!=',2)->get();
        //return $fx;
        //$users = User::all()->except(Auth::id());
        $jsonApi = json_decode(file_get_contents(resource_path() . '\api\malaysia_banks.json'), true);
        return $jsonApi;
        foreach ($jsonApi as $key) {
            //$country[]=[$key,$data];
            $alpha_2_code[] = $key['name'];
            //$countries[] = $data;
        }
        return $alpha_2_code;
        return $jsonApi;
        //return json_decode(Http::get($jsonApi));
        /* $client = json_decode(Http::get('http://country.io/names.json'));
        foreach($client as $key=>$data){
            $country[]=[$key,$data];
            //$alpha_2_code[] = $key;
            //$countries[] = $data;
        }
        return $country[rand(0, count($country) - 1)][1]; */
    }

    function multi_sort($array, $akey)
    {
        function compare($a, $b)
        {
            global $key;
            return strcmp($a[$key], $b[$key]);
        }
        usort($array, "compare");
        return $array;
    }

    /* public function getAlpha2Code(){
        return Country::find(1,['alpha_2_code']);
    } */

    public function getAlpha2Code(Request $request)
    {
        return Country::find($request->id, ['alpha_2_code']);
    }

    public function showCountries()
    {
        $country = Country::all();
        return $country;
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
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }
}
