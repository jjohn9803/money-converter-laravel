<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\TimeoutJob;
use App\Jobs\VerifyEmailJob;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Fx;
use App\Models\HomePage;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \Illuminate\View\View;
use \App\Tables\UsersTable;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    //App::getLocale()
    /* protected $usd_to_myr = 1;
    protected $realtime_curr_list = []; */

    /* public function __construct()
    {
        //$this->middleware(['auth','verified']);
        $this->middleware(['setLocale']);
    } */

    public function getLocale()
    {
        if (str_contains(config('app.locale'), 'zh')) {
            return 'zh';
        } else {
            return config('app.locale');
        }
    }

    public function index()
    {
        $currencies = Currency::where('id', 1)->get()->merge(Currency::has('result_currency')->where('id', '!=', 1)->get());
        /* array_unshift($currencies, Currency::find(1)); */
        $countries = Country::all();
        $banks = Bank::all();
        $bank_accounts = BankAccount::leftJoin('banks', 'banks.id', '=', 'bank_accounts.bank_id')->where('status', '=', 1)->select('bank_accounts.*', 'banks.country_id')->get();
        $bank_accounts = $bank_accounts->map(function ($object) {
            $object->country_id = array_map('intval', json_decode($object->country_id));
            return $object;
        });
        $currencies_countries = Currency::with('country')->where('id', 1)->get()->merge(Currency::with('country')->has('result_currency')->where('id', '!=', 1)->whereColumn('max_amt', '>', 'min_amt')->where('min_amt', '>=', '0')->get());
        /* array_unshift($currencies_countries, Currency::find(1)); */
        $fxes = Fx::whereIn('id', Fx::select(DB::raw('MAX(id)'))->groupBy(['result_currency_id'])->pluck('MAX(id)')->toArray())->get();
        $contacts = Contact::all();
        $home_pages = HomePage::all();
        $fake_data = [];
        for ($i = 0; $i < 10; $i++) {
            $fake_name = \Faker\Factory::create()->userName;
            $fake_name = substr($fake_name, 0, -3) . '***';
            $fake_curr_get = Currency::has('result_currency')->where('id', '!=', 1)->get();
            if ($fake_curr_get->count() >0) {
                $fake_curr = $fake_curr_get->random();
                $fake_country = Country::find($fake_curr->id);
                $fake_country_name = $fake_country->name;
                $fake_minutes = rand(3, 15);
                $fake_curr_name = $fake_curr->name;
                $fake_curr_min_amt = $fake_curr->min_amt;
                $fake_curr_max_amt = $fake_curr->max_amt;
                $fake_fxes = Fx::where('result_currency_id', '=', $fake_curr->id)->first()->fx_rate;
                $fake_amount = number_format((rand($fake_curr_min_amt, $fake_curr_max_amt) * 0.005), 2);
                array_push($fake_data, __('content.exchange.marquee', [
                    'name' => $fake_name,
                    'country' => $fake_country_name,
                    'sec' => $fake_minutes,
                    'amount' => $fake_amount,
                    'currency' => $fake_curr_name,
                ]));
            }
        }

        $verified = null;
        if (Auth::check()) {
            if ((Auth::user()->hasVerifiedEmail())) {
                $verified = true;
            } else {
                $verified = false;
            }
        }
        /* return [
            'currencies' => $currencies,
            'countries' => $countries,
            'banks' => $banks,
            'bank_accounts' => $bank_accounts,
            'fxes' => $fxes,
            'currencies_countries' => $currencies_countries,
            'home_pages' => $home_pages,
            'contacts' => $contacts,
            'verified' => $verified,
        ]; */
        //self::getRealTime();
        $is_maintenance = $home_pages->where('name', 'Maintenance')->first()->value['boolean'];
        $wh_start = $home_pages->where('name', 'Working Hours')->first()->value['start'];
        $wh_end = $home_pages->where('name', 'Working Hours')->first()->value['end'];
        $homepage_tel = $home_pages->where('name', 'Tel')->first()->value['value'];
        $homepage_email = $home_pages->where('name', 'Email')->first()->value['value'];
        $homepage_tc = $home_pages->where('name', 'Transaction Complete')->first()->value['value'];
        $homepage_ms = $home_pages->where('name', 'Money Saved')->first()->value['value'];
        $homepage_hts = $home_pages->where('name', 'Hours Time Saved')->first()->value['value'];
        $homepage_fee = $home_pages->where('name', 'Fee')->first()->value['value'];
        $homepage_bank = $home_pages->where('name', 'Bank')->first()->value['value'];

        return view('homepage')->with([
            'currencies' => $currencies,
            'countries' => $countries,
            'banks' => $banks,
            'bank_accounts' => $bank_accounts,
            'fxes' => $fxes,
            'currencies_countries' => $currencies_countries,
            'home_pages' => $home_pages,
            'contacts' => $contacts,
            'verified' => $verified,
            'data' => $fake_data,
            'wh_start' => $wh_start,
            'wh_end' => $wh_end,
            'is_maintenance' => $is_maintenance,
            'homepage_tel' => $homepage_tel,
            'homepage_email' => $homepage_email,
            'homepage_tc' => $homepage_tc,
            'homepage_ms' => $homepage_ms,
            'homepage_hts' => $homepage_hts,
            'homepage_fee' => $homepage_fee,
            'homepage_bank' => $homepage_bank,
        ]);
    }

    /* function getRealTime()
    {
        $response = Http::withHeaders(
            [
                'X-RapidAPI-Key' => 'e048c447eemsh6d3d83643dbb2b0p1ed171jsn66126b55cb3f',
                'X-RapidAPI-Host' => 'currencyscoop.p.rapidapi.com',
            ]
        )->get('https://currencyscoop.p.rapidapi.com/latest');

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

    public function getNotification(Request $request)
    {
        if (request()->ajax() && Auth::check()) {
            $notification = Notification::with(['transasction'])
                //->join('user', 'user.id', 'notifications.user_id')
                ->with(['reason'])
                ->where('notifications.user_id', '=', Auth::user()->id);
            /* Notification::join('transactions', 'transactions.id', 'notifications.transasction_id')
            //->join('user', 'user.id', 'notifications.user_id')
            ->join('reasons', 'reasons.id', 'notifications.reason_id')
            ->select(
                'notifications.status as notification_status',
                'notifications.message_type as notification_type',
                'transactions.id as t_id',
                'reasons.message as reason_json',
                'notifications.created_at as created_at',
            )->where('notifications.user_id', '=', Auth::user()->id); */
            if ($request->read_filter == 2) {
                $notification = $notification->where('status', '=', '1');
            } else if ($request->read_filter == 3) {
                $notification = $notification->where('status', '=', '2');
            }
            if ($request->order == 2) {
                $notification = $notification->orderBy('created_at', 'asc');
            } else {
                $notification = $notification->orderBy('created_at', 'desc');
            }
            $notification = $notification->get();
            return response()->json(['notification' => $notification]);
        } else {
            return abort(404);
        }
    }

    /* public function getNotificationById($id)
    {
        if (Auth::check()) {
            $notification = Notification::whereHas('transasction', function ($query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->orderBy('created_at', 'desc')->get();
        } else {
            return abort(404);
        }
    } */

    public function viewNotification(Request $request)
    {
        if (Auth::check()) {
            if ($request->id) {
                $ref_no = Transaction::where('id', Crypt::decrypt($request->id))->first()->ref_no;
                return view('notification.notification-all')->with([
                    'notification' => $ref_no,
                ]);
                /* return view('notification.notification-all')->with([
                    'notification' => Crypt::decrypt($request->id),
                ]); */
            } else {
                return view('notification.notification-all');
            }
            /* $notification = Notification::whereHas('transasction', function ($query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->orderBy('created_at', 'desc')->get();
            return view('notification.notification-all')->with([
                'notification' => $notification,
            ]); */
        } else {
            return abort(404);
        }
    }

    public function updateNotification(Request $request)
    {
        if (Auth::check()) {
            /* $notification = Notification::whereHas('transasction', function ($query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->find($request->id); */
            $notification = Notification::where('user_id', '=', Auth::user()->id)->find($request->id);
            if ($notification->status == 1) {
                $notification->status = 2;
                if (!$notification->save()) {
                    return response()->json([], 500);
                }
            }
            if ($notification->transasction_id == -1) {
                return response()->json([
                    'id' => Crypt::encrypt($notification->transasction_id),
                    'redirect' => false,
                ], 200);
            } else {
                return response()->json([
                    'id' => Crypt::encrypt($notification->transasction_id),
                    'redirect' => true,
                ], 200);
            }
        }
    }

    public function readAllNotification(Request $request)
    {
        if (Auth::check()) {
            /* $notification = Notification::whereHas('transasction', function ($query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->where('status', '=', '1')->update(['status' => '2']); */
            $notification = Notification::where('user_id', '=', Auth::user()->id)->where('status', '=', '1')->update(['status' => '2']);
            if ($notification) {
                return response()->json([], 200);
            } else {
                return response()->json([], 204);
            }
        }
    }

    public function validateForm(Request $request)
    {
        //return $request;
        $from_curr = Currency::where('id', '=', $request->from_curr)->first();
        $to_curr = Currency::where('id', '=', $request->to_curr)->first();
        $from_country = Country::where('id', '=', $request->from_country)->first();
        $to_country = Country::where('id', '=', $request->to_country)->first();
        $bank_accounts = BankAccount::where('status', '=', 1)->inRandomOrder()->first();
        if (!$from_curr || !$to_curr || !$from_country || !$to_country) {
            return response()->json(['error' => ['swal' => __('content.swal.smtg-went-wrong')]]);
        }
        if (!$bank_accounts) {
            return response()->json(['error' => ['swal' =>  __('content.swal.under-maintenance')]]);
        }

        $validator = Validator::make($request->all(), [
            'from_amount' => 'required||numeric||min:' . $from_curr->min_amt . '||max:' . $from_curr->max_amt,
            'agree' => 'accepted',
            'your_bank' => 'required||numeric||min:1',
            'your_bank_acc' => 'required||nullable||min:6',
            'your_receive_bank' => 'required||numeric||min:1',
            'your_receive_bank_acc' => 'required||nullable||min:6',
        ], array(
            'from_amount.min' => __('content.validatorForm.from_amount.min', ['from_curr-name' => $from_curr->name]),
            'from_amount.max' => __('content.validatorForm.from_amount.max', ['from_curr-name' => $from_curr->name]),
            'from_amount.required' => __('content.validatorForm.from_amount.required'),
            'your_bank.required' => __('content.validatorForm.your_bank.required'),
            'your_bank_acc.required' => __('content.validatorForm.your_bank_acc.required'),
            'your_bank_acc.min' => __('content.validatorForm.your_bank_acc.min'),
            'your_receive_bank.required' => __('content.validatorForm.your_receive_bank.required'),
            'your_receive_bank_acc.required' => __('content.validatorForm.your_receive_bank_acc.required'),
            'your_receive_bank_acc.min' => __('content.validatorForm.your_receive_bank_acc.min'),
            'agree.accepted' => __('content.validatorForm.agree.accepted'),
        ));
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages(),
            ]);
        }
        return response()->json([$request], 201);
    }

    public function receipt(Request $request)
    {
        //$user = User::find(1);
        $wh_start = HomePage::where('name', 'Working Hours')->first()->value['start'];
        $wh_end = HomePage::where('name', 'Working Hours')->first()->value['end'];
        $is_maintenance = HomePage::where('name', 'Maintenance')->first()->value['boolean'];

        if (!Auth::check() || (!(Carbon::now()->between($wh_start, $wh_end)) && ($wh_start != $wh_end)) || $is_maintenance) {
            return abort(404);
        }
        $uid = Auth::user()->id;

        $uniqueRefNo = \Faker\Factory::create()->unixTime($max = 'now');
        while (Transaction::where('ref_no', '=', $uniqueRefNo)->exists()) {
            $uniqueRefNo = \Faker\Factory::create()->unixTime($max = 'now');
        }
        $currencies = Currency::all();
        $from_curr = $currencies->find($request->from_curr);
        $to_curr = $currencies->find($request->to_curr);
        $countries = Country::all();
        $from_bank = Bank::find($request->your_bank);
        $your_receive_bank = Bank::find($request->your_receive_bank);
        $bank_accounts = BankAccount::whereHas('bank', function ($query) use ($from_bank) {
            return $query->whereJsonContains('country_id', $from_bank->country_id);
        })->inRandomOrder()->first();
        $to_recipient = Bank::find($bank_accounts->bank_id);
        //$banks->country_id
        if (!$bank_accounts) {
            return abort(500, __('content.swal.under-maintenance'));
            //return 'not support';
        }
        $currencies_countries = Currency::with('country')->get();
        $fxes = Fx::whereIn('id', Fx::select(DB::raw('MAX(id)'))->groupBy(['result_currency_id'])->pluck('MAX(id)')->toArray())->get();
        //$request->from_curr
        //$request->to_curr
        $def_base_curr_id = 1;
        foreach ($currencies as $key => $value) {
            if ($value->name == 'MYR') {
                $def_base_curr_id = $value->id;
            }
        }
        $base_fx_rate = ($request->from_curr == $def_base_curr_id ? 1 : -1);
        $result_fx_rate = ($request->to_curr == $def_base_curr_id ? 1 : -1);

        foreach ($fxes as $key => $value) {
            if ($value->result_currency_id == $request->from_curr) {
                $base_fx_rate = $value->fx_rate;
            }
            if ($value->result_currency_id == $request->to_curr) {
                $result_fx_rate = $value->fx_rate;
            }
        }
        $fx_rate = (1 / $base_fx_rate) * $result_fx_rate;
        $to_amount = (int)($request->from_amount * $fx_rate);
        $receive_bank_id = $bank_accounts->id;
        $receive_bank_acc_no = $bank_accounts->account_no;
        /* return [
            'user_id' => $uid,
            'from_acc' => $request->your_bank_acc,
            'from_bank' => $request->your_bank,
            'to_acc_id' => $receive_bank_id,
            'from_curr_id' => $request->from_curr,
            'to_curr_id' => $request->to_curr,
            'fx_rate' => $fx_rate,
            'from_amount' => $request->from_amount,
            'to_amount' => $to_amount,
            'ref_no' => $uniqueRefNo,
            'status' => '1',
        ]; */

        $transaction = Transaction::create([
            'user_id' => $uid,
            'from_acc' => $request->your_bank_acc,
            'from_bank' => $from_bank, //json
            'your_receive_acc' => $request->your_receive_bank_acc,
            'your_receive_bank' => $your_receive_bank, //json
            'to_acc_id' => collect(
                array_merge(
                    json_decode($bank_accounts, true),
                    ["bank_name" => $to_recipient->name]
                )
            ), //json
            'from_curr_id' => $from_curr, //json
            'to_curr_id' => $to_curr, //json
            'fx_rate' => $fx_rate,
            'from_amount' => $request->from_amount,
            'to_amount' => $to_amount,
            'ref_no' => $uniqueRefNo,
            'status' => '1',
        ]);

        $expired_date = $transaction->created_at->addMinutes(10);
        TimeoutJob::dispatch($transaction)->delay($expired_date);
        $message = "##" . $transaction->id . "##";
        /* $order = "__('content.notification.order',['transaction_id'=>'". str_pad($transaction->id, 5, '0', STR_PAD_LEFT) ."'])";
        $message = "__('content.notification.pending',['order'=>'".$order."'])"; */
        /* $order = '<b>Order #' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT) . '</b>';
        $message = 'Your ' . $order . ' has been pending! Please do further transactions within 10 minutes!'; */
        //$transaction->status = $request->status;
        $notification = Notification::create([
            'user_id' => $uid,
            'transasction_id' => $transaction->id,
            'message_type' => 1,
            'reason_id' => -1,
            'status' => 1,
        ]);
        /* $schedule = new Schedule();
        $schedule->call('App\Http\Controllers\TransactionController@updateTransaction(1)')->when(function (){
            return $transaction->created_at->addMinutes(1)->isPast();
        }); */
        //return Redirect::route('view-receipt')->with(['id'=>$transaction->id]);
        //return Redirect::route('view-receipt', ['id' => $transaction->id]);
        return redirect("view-receipt/" . Crypt::encrypt($transaction->id));
    }

    public function viewReceipt($id)
    {
        if (!Auth::check()) {
            return abort(404);
        }
        try {
            $home_pages_tel = HomePage::where('name', 'Tel')->first()->value['value'];
            $home_pages_email = HomePage::where('name', 'Email')->first()->value['value'];
            $user = User::find(Auth::user()->id);
            $transaction = Transaction::where('transactions.user_id', '=', Auth::user()->id)
                ->where('transactions.id', '=', Crypt::decrypt($id))
                ->first();
            //$to_acc_bank = Bank::find($transaction->to_acc_id['bank_id']);
            if ($transaction == '[]') {
                return abort(404);
            }
            $expired_date = $transaction->created_at->addMinutes(10);
            return view('receipt.receipt')->with([
                'id' => $id,
                'email' => $user->email,
                'from_acc' => $transaction->from_acc,
                'from_bank' => $transaction->from_bank['name'],
                'your_receive_acc' => $transaction->your_receive_acc,
                'your_receive_bank' => $transaction->your_receive_bank['name'],
                'from_curr' => $transaction->from_curr_id['name'],
                'to_curr' => $transaction->to_curr_id['name'],
                'from_amount' => $transaction->from_amount,
                'fx_rate' => $transaction->fx_rate,
                'result_amount' => $transaction->to_amount,
                'recipient_acc' => $transaction->to_acc_id['account_no'],
                'recipient_bank_name' => $transaction->to_acc_id['bank_name'],
                'receipt_img_path' => $transaction->receipt_img_path,
                'recipient_receipt_img' => $transaction->recipient_receipt_img_path,
                'ref_no' => $transaction->ref_no,
                'status' => $transaction->status,
                'end_date' => $expired_date,
                'home_page_tel' => $home_pages_tel,
                'home_page_email' => $home_pages_email,
                /* 'currencies' => $currencies,
            'countries' => $countries,
            'banks' => $banks,
            'bank_accounts' => $bank_accounts,
            'fxes' => $fxes,
            'currencies_countries' => $currencies_countries, */
            ]);
        } catch (DecryptException $e) {
            return abort(502, $e);
        }
    }

    public function validateRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_username' => [
                'required', 'min:3', 'unique:users,name'
            ],
            'login_email' => [
                'required', 'email', 'unique:users,email'
            ],
            'login_password' => [
                'required', 'min:6'
            ],
            'login_rpassword' => [
                'required', 'same:login_password'
            ],
        ],);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages(),
            ]);
        }
        return response()->json([$request], 201);
    }

    public function validateLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_email' => 'required|email',
            'login_password' => 'required|min:6'
        ],);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages(),
            ]);
        }
        if (Auth::attempt(['email' => $request->login_email, 'password' => $request->login_password])) {
            return response()->json(200);
        } else {
            return response()->json([
                'error' => [
                    'message' => trans('auth.failed'),
                ],
            ]);
        }
        /* $user = User::where('email','=',$request->login_email)->first();
        $validator2 = Validator::make($request->all(), [
            'login_email' => 'unique:users,email,'.$user->id,
        ],);
        if ($validator2->fails()) {
            return response()->json([
                'error' => $validator2->messages(),
            ]);
        } */
        /* return 0;
        $name = $request->get('login_email');
        $factory = $request->container->make(ValidationFactory::class);

        $isEmail = !$factory->make(
            ['name' => $name],
            ['name' => 'email']
        )->fails();
        if ($isEmail) {
            return [
                'email' => $name,
                'password' => $request->get('login_password')
            ];
        }
        $credentials = $request->only('login_email', 'login_password');
        if (!Auth::validate($credentials)) {
            return response()->json([
                'error' => trans('auth.failed'),
            ]);
        }
        return response()->json([$request], 201); */
    }

    protected function isEmail($param)
    {
        $factory = $this->container->make(ValidationFactory::class);

        return !$factory->make(
            ['name' => $param],
            ['name' => 'email']
        )->fails();
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)) :
            return redirect()->to('/')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if ($request->remember) {
            Auth::login($user, $remember = true);
        } else {
            Auth::login($user);
        }


        return $this->authenticated($request, $user);
    }

    public function register(Request $request)
    {
        //return $request;
        /* $validator = Validator::make($request->all(), [
            'login_username' => [
                'required', 'min:3', 'unique:users,name'
            ],
            'login_email' => [
                'required', 'email', 'unique:users,email'
            ],
            'login_password' => [
                'required', 'min:6'
            ],
            'login_rpassword' => [
                'required', 'same:login_password'
            ],
        ],);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages(),
            ]);
        }
        return response()->json([$request], 201); */
        /* return $validator;
        return response()->json([
            'error' => trans('auth.failed'),
        ]);

        if ($request->validated()) {
            return 'yes';
        } else {
            return 'fail';
        } */
        //return $request;
        $user = User::create([
            'name' => $request->login_username,
            'email' => $request->login_email,
            'password' => Hash::make($request->login_password),

        ]);

        auth()->login($user);
        VerifyEmailJob::dispatch($user);
        //$user->sendEmailVerificationNotification();
        return redirect('/')->with('register', "Account successfully registered.");
    }

    public function exist_email(Request $request)
    {
        $email = User::where('email', $request->email)->count();
        if ($email == 1) {
            return response()->json(['success'], 201);
        } else {
            return response()->json(['fail'], 200);
        }
    }
}
