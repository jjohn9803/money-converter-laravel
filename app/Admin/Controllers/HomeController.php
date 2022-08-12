<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Currency;
use App\Models\Fx;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
  public function index(Content $content)
  {
    /* return Admin::content(function (Content $content) {

      $content->header('chart');
      $content->description('.....');

      $content->body(view('admin.charts.bar'));
    }); */

    return $content
      ->title(__('content.title'))
      ->description(__('content.index-h1.1'))
      /* ->row(Dashboard::title()) */
      ->row(function (Row $row) {
        /* $row->column(4, function (Column $column) {
          $total_users = User::count();
          $today_users = User::whereDate('created_at', '=', Carbon::today())->count();
          $yesterday_users = User::whereDate('created_at', '=', Carbon::yesterday())->count();
          $column->append(view);
        }); */
        $row->column(4, function (Column $column) {
          $total_fxes = Transaction::with('to_curr')->selectRaw('to_curr_id,COUNT(*) as order_count')
            ->groupBy('to_curr_id')
            ->orderByRaw('COUNT(*) DESC')
            ->first();
          $total_act_bank_acc = BankAccount::where('status', '1')->count();
          $column->append("
                    <link rel='icon' type='image/x-icon' href='/images/favicon.ico'>
                    <div class='card text-white' style='border-style: solid;
                    border-color: white;color:white;background-color: #ccc933;padding: 2rem;margin-bottom:2rem;height:200px;'>
                    <div class='card-header'>Famous Currency</div>
                    <div class='card-body'>
                    <div style='float:right; margin-left:1rem;margin-right:1rem;margin-bottom:2rem;'><i class='fa fa-money fa-4x' aria-hidden='true'></i></div>
                      <h2 class='card-title' style='font-weight:bold;'>" . $total_fxes->order_count . "</h2>
                      <h3 class='card-title' style='font-style:italic;'>(" . $total_fxes->to_curr->name . ")</h3>
                    </div>
                  </div>");
        });
        $row->column(4, function (Column $column) {
          $total_order = Transaction::all()->count();
          $today_order = Transaction::whereDate('created_at', Carbon::today())->count();
          $yesterday_order = Transaction::whereDate('created_at', Carbon::yesterday())->count();
          $column->append("
                    <link rel='icon' type='image/x-icon' href='/images/favicon.ico'>
                    <div class='card text-white' style='border-style: solid;
                    border-color: white;color:white;background-color: #ccc933;padding: 2rem;margin-bottom:2rem;height:200px;'>
                    <div class='card-header'>Total Orders</div>
                    <div class='card-body'>
                    <div style='float:right; margin-left:1rem;margin-right:1rem;margin-bottom:2rem;'><i class='fa fa-whatsapp fa-4x' aria-hidden='true'></i></div>
                      <h2 class='card-title' style='font-weight:bold;'>$total_order</h2>
                      <a href='/admin/orders' class='btn btn-default popup' style='text-align:left;'>
                        Today Count : <span class='badge'>$today_order</span> <br>
                        Yesterday Count : <span class='badge'>$yesterday_order</span>
                        </a>
                    </div>
                  </div>");
        });
        $row->column(3, function (Column $column) {
          $total_order = Bank::all()->count();
          $column->append("
                    <link rel='icon' type='image/x-icon' href='/images/favicon.ico'>
                    <div class='card text-white' style='border-style: solid;
                    border-color: white;color:white;background-color: #ccc933;padding: 2rem;margin-bottom:2rem;'>
                    <div class='card-header'>Total Banks</div>
                    <div class='card-body'>
                    <div style='float:right; margin-left:1rem;margin-right:1rem;margin-bottom:2rem;'><i class='fa fa-university fa-4x' aria-hidden='true'></i></div>
                      <h2 class='card-title' style='font-weight:bold;'>$total_order</h2>
                    </div>
                  </div>");
        });
        $row->column(3, function (Column $column) {
          $total_order = Transaction::with('to_curr')->selectRaw('to_curr_id,COUNT(*) as order_count')
            ->groupBy('to_curr_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(3)
            ->get();
          $column->append("
                    <link rel='icon' type='image/x-icon' href='/images/favicon.ico'>
                    <div class='card text-white' style='border-style: solid;
                    border-color: white;color:white;background-color: #ccc933;padding: 2rem;margin-bottom:2rem;'>
                    <div class='card-header'>Famous Currency</div>
                    <div class='card-body'>
                    <div style='float:right; margin-left:1rem;margin-right:1rem;margin-bottom:2rem;'><i class='fa fa-usd fa-4x' aria-hidden='true'></i></div>
                      <h2 class='card-title' style='font-weight:bold;'>" . $total_order[0]->to_curr->name . "</h2>
                    </div>
                  </div>");
        });
        $row->column(3, function (Column $column) {
          $total_bank_acc = BankAccount::count();
          $column->append("
                    <link rel='icon' type='image/x-icon' href='/images/favicon.ico'>
                    <div class='card text-white' style='border-style: solid;
                    border-color: white;color:white;background-color: #ccc933;padding: 2rem;margin-bottom:2rem;'>
                    <div class='card-header'>Bank Account</div>
                    <div class='card-body'>
                    <div style='float:right; margin-left:1rem;margin-right:1rem;margin-bottom:2rem;'><i class='fa fa-user-secret fa-4x' aria-hidden='true'></i></div>
                      <h2 class='card-title' style='font-weight:bold;'>" . $total_bank_acc . "</h2>
                    </div>
                  </div>");
        });
        $row->column(3, function (Column $column) {
          $total_curr = Currency::count();
          $column->append("
                    <link rel='icon' type='image/x-icon' href='/images/favicon.ico'>
                    <div class='card text-white' style='border-style: solid;
                    border-color: white;color:white;background-color: #ccc933;padding: 2rem;margin-bottom:2rem;'>
                    <div class='card-header'>Famous Currency</div>
                    <div class='card-body'>
                    <div style='float:right; margin-left:1rem;margin-right:1rem;margin-bottom:2rem;'><i class='fa fa-balance-scale fa-4x' aria-hidden='true'></i></div>
                      <h2 class='card-title' style='font-weight:bold;'>" . $total_curr . "</h2>
                    </div>
                  </div>");
        });
        /* $row->column(12, function (Column $column) {
          return $column->append(view('admin.charts.bar'));
        }); */

        /* $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                }); */
      });
  }

  function latestDaysArray($date, $numDays)
  {
    $array_date[0] = $date->format('Y-m-d');
    for ($i = 1; $i < $numDays; $i++) {
      $array_date[$i] = $date->subDays(1)->format('Y-m-d');
    }
    sort($array_date);
    return $array_date;
  }

  function getRealTimeCurrency($currency_code, $date)
  {
    //$date = self::latestDaysArray(Carbon::now(),5);
    $session = ['0900', '1130', '1200', '1700'];
    $quote = 'rm';
    foreach ($session as $key => $value) {
      $url = 'https://api.bnm.gov.my/public/exchange-rate/' . $currency_code . "/date/" . $date . '?session=' . $value . '&quote=' . $quote;
      $response = Http::withHeaders(
        [
          'Accept' => 'application/vnd.BNM.API.v1+json',
        ]
      )->get($url);
      if ($response->status() == '404') {
        $result[$value] = [];
      } else {
        $result[$value] = $response['data'];
      }
    }
    return $result;
  }

  public function getRecentRecord()
  {
    //return $date = self::latestDaysArray(Carbon::now(), 5);
    /* $date = self::latestDaysArray(Carbon::now(), 5);
    foreach ($date as $key => $value) {
      $result[$key] = self::getRealTimeCurrency('SGD', $value);
    }
    return $result; */
    $curr = [
      'USD', 'EUR', 'SGD', 'JPY', 'KRW'
    ];

    foreach ($curr as $key => $curr) {
      $date = Carbon::parse(self::getLatestDate());
      $result_temp = self::getRealTime(self::latestDaysArray($date, 5), $curr);
      $result[$curr] = $result_temp;
    }

    return $result;
  }

  function getRealTime($date, $curr)
  {
    foreach ($date as $key => $value) {
      $response = Http::withHeaders(
        [
          'X-RapidAPI-Key' => 'e048c447eemsh6d3d83643dbb2b0p1ed171jsn66126b55cb3f',
          'X-RapidAPI-Host' => 'currencyscoop.p.rapidapi.com',
        ]
      )->get('https://currencyscoop.p.rapidapi.com/historical', [
        'date' => $value
      ]);
      if (count($response['response']['rates']) > 0) {
        $usd_to_myr = $response['response']['rates']['MYR'];
        $result[$key] = array(
          'rate' => self::convertBasedOnMYR($usd_to_myr, $response['response']['rates'][$curr]),
          'date' => $value,
        );
      } else {
        ///return false;
        $result[$key] = array();
      }
    }
    return $result;
  }

  function getLatestDate()
  {
    $response = Http::withHeaders(
      [
        'X-RapidAPI-Key' => 'e048c447eemsh6d3d83643dbb2b0p1ed171jsn66126b55cb3f',
        'X-RapidAPI-Host' => 'currencyscoop.p.rapidapi.com',
      ]
    )->get('https://currencyscoop.p.rapidapi.com/latest');
    if (count($response['response']) > 0) {
      $lastest_date = $response['response']['date'];
      return $lastest_date;
    } else {
      return false;
    }
  }

  function convertBasedOnMYR($usd_to_myr, $result_curr)
  {
    $result_curr =  $result_curr / $usd_to_myr;
    return $result_curr;
  }
}
