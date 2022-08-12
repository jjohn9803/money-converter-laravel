<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\BetRecord;
use App\Models\Currency;
use App\Models\Fx;
use App\Models\Transaction;
use App\Models\WinRecord;
use App\Models\User;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;

class DashboardController extends Controller
{
    public function index(Content $content)
    {
        $s = Carbon::now()->format('Y-m-d 00:00:00');
        $t = Carbon::now()->format('Y-m-d 23:59:59');
        return $content
            ->title(__('admin.custom.dashboard.title'))
            ->body($this->view($s, $t));
    }

    public function store(Content $content)
    {
        $s = request('created_at');
        $s = Carbon::parse($s)->format('Y-m-d 00:00:00');
        $t = request('to_at');
        $t = Carbon::parse($t)->format('Y-m-d 23:59:59');
        return $content
            ->title(__('admin.custom.dashboard.data-search'))
            ->body($this->view($s, $t));
    }

    public function view($s, $t)
    {
        $dailyTransactions = Transaction::whereBetween('created_at', [$s, $t]);
        $dailyAcceptedTransactions = Transaction::whereBetween('created_at', [$s, $t])->where('status', 4);
        $dailyRejectedTransactions = Transaction::whereBetween('created_at', [$s, $t])->where('status', 5);
        $dailyPopularBaseFx_id = Transaction::select('from_curr_id')
            ->selectRaw('COUNT(*) AS count')
            ->whereBetween('created_at', [$s, $t])
            ->groupBy('from_curr_id')
            ->orderByDesc('count')
            ->limit(1)
            ->first();
        if ($dailyPopularBaseFx_id != null) {
            $dailyPopularBaseFx_name = Currency::where('id', $dailyPopularBaseFx_id->from_curr_id)->first()->name;
            $dailyPopularBaseFx = $dailyPopularBaseFx_name . '(' . $dailyPopularBaseFx_id->count . ')';
        } else {
            $dailyPopularBaseFx = '-';
        }
        $dailyPopularResultFx_id = Transaction::select('to_curr_id')
            ->selectRaw('COUNT(*) AS count')
            ->whereBetween('created_at', [$s, $t])
            ->groupBy('to_curr_id')
            ->orderByDesc('count')
            ->limit(1)
            ->first();
        if ($dailyPopularResultFx_id != null) {
            $dailyPopularResultFx_name = Currency::where('id', $dailyPopularResultFx_id->to_curr_id)->first()->name;
            $dailyPopularResultFx = $dailyPopularResultFx_name . '(' . $dailyPopularResultFx_id->count . ')';
        } else {
            $dailyPopularResultFx = '-';
        }
        $dailyUsers = User::whereBetween('created_at', [$s, $t]);
        $TotalUsers = User::whereBetween('created_at', [$s, $t])->where('email_verified_at', '!=', null);

        //Canvas
        $canvasTransactions = Transaction::select(
            DB::raw("(count(id)) as total_count"),
            DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as my_date")
        )
            ->whereBetween('created_at', [$s, $t])
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
            ->get();
        $canvasAcceptedTransactions = Transaction::select(
            DB::raw("(count(id)) as total_count"),
            DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as my_date")
        )
            ->whereBetween('created_at', [$s, $t])
            ->where('status', 4)
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
            ->get();
        $canvasRejectedTransactions = Transaction::select(
            DB::raw("(count(id)) as total_count"),
            DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as my_date")
        )
            ->whereBetween('created_at', [$s, $t])
            ->where('status', 5)
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
            ->get();

        return view('admin.dashboard.data-with-filter', compact(
            'dailyTransactions',
            'dailyAcceptedTransactions',
            'dailyRejectedTransactions',
            'dailyPopularBaseFx',
            'dailyPopularResultFx',
            'dailyUsers',
            'TotalUsers',
            's',
            't',
            'canvasTransactions',
            'canvasAcceptedTransactions',
            'canvasRejectedTransactions',
        ));
    }
}
