<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Transactions\DealTransactions;
use App\Models\Currency;
use App\Models\Fx;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class FxController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.fxes.title');
    }
    public static $usd_to_myr = -1;
    public static $realtime_curr_list = [];
    public static $local_realtime_curr_list = [];
    public static $local_api_only = true;
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        if(session()->has('fx_session')){
            if (session('fx_session')->diffInMinutes(Carbon::now()) > 60) {
                session()->forget('fx_session');
                session()->forget('realtime_curr_list');
                session()->forget('local_realtime_curr_list');
                \Encore\Admin\Admin::script('console.log("load fx rate at first");');
            }
        }
        if (!session()->has('fx_session')) {
            session()->put('fx_session', Carbon::now());
            self::apiLocal();
            $this->getRealTime();
            session()->put('realtime_curr_list', self::$realtime_curr_list);
            session()->put('local_realtime_curr_list', self::$local_realtime_curr_list);
        }

        //self::apiLocal();
        /* dd(self::$local_realtime_curr_list);
        return self::$local_realtime_curr_list; */
        //$this->getRealTime();

        $grid = new Grid(new Fx());
        $grid->disableBatchActions();
        $grid->model()->orderBy('created_at', 'desc');
        $grid->filter(function ($filter) {
            $filter->like('result_currency.name', __('admin.custom.fxes.result_curr'));
            $filter->between('fx_rate', __('admin.custom.fxes.fx_rate'));
            $filter->date('created_at', __('admin.custom.created_at'));
        });
        $grid->disableActions();
        $grid->disableCreateButton();
        //$grid->column('id');
        $grid->model()->whereIn('id', Fx::select(DB::raw('MAX(id)'))->groupBy(['result_currency_id'])->pluck('MAX(id)'));
        //collect($array)->sortBy('result_currency.name')->toArray()
        //echo($grid->model());
        //collect($array)->sortBy('result_currency.name')->toArray()
        /* $grid->model()->whereIn('id',Fx::select(DB::raw('MAX(id)'))->groupBy(['base_currency_id','result_currency_id'])->pluck('MAX(id)')->toArray()); */
        /* $grid->model()->groupBy(['base_currency_id','result_currency_id'])->orderBy('created_at','desc'); */
        //$grid->column('base_currency.name', __('Base Currency'));
        /* $grid->column('base_currency.name', 'Base Currency')->expand(function ($model) {
            //FX::where('base_currency_id', $base)->where('result_currency_id', $result)->where('id','!=',2)->get();
            $history = $model->where('base_currency_id', $model->base_currency_id)->where('result_currency_id', $model->result_currency_id)->where('id','!=',$model->id)->orderBy('id','DESC')->take(10)->get()->map(function ($history) {
                return $history->only(['id','fx_rate','created_at']);
            });
        
            return new Table(['Id','Fx Rate','Created At'], $history->toArray());
        }); */
        /* $grid->column('base_currency.name', __('Base Currency')); */
        $grid->column(__('admin.custom.fxes.base_curr'))->display(function () {
            return 'MYR';
        });

        $grid->column('result_currency.name', __('admin.custom.fxes.result_curr'))->sortable();
        $grid->column('fx_rate', __('admin.custom.fxes.fx_rate'));

        $grid->column(__('admin.custom.fxes.real_fx_rate'))->display(function () {
            $curr_name = $this->result_currency->name;
            if (empty(session('local_realtime_curr_list')[$curr_name]) || session('local_realtime_curr_list')[$curr_name] == null) {
                return Self::convertBasedOnMYR($curr_name);
            } else {
                return session('local_realtime_curr_list')[$curr_name];
            }
            /* if (empty(self::$local_realtime_curr_list[$curr_name]) || self::$local_realtime_curr_list[$curr_name] == null) {
                return Self::convertBasedOnMYR($curr_name);
            } else {
                return self::$local_realtime_curr_list[$curr_name];
            } */
        });
        /* call_user_func(function($grid,$_this){
            return $grid->column('Real-time Rate')->display(function ($_this) {
                return $_this->convertBasedOnMYR($this->realtime_curr_list, 'SGD');
            });
        },array($grid,$this)); */

        //$grid->column('created_at', __('Created at'))->date('Y-m-d')->sortable();
        $grid->column('created_at', __('admin.custom.created_at'));
        /* $grid->column('created_at', __('admin.custom.created_at'))->display(function ($grid, $column) {
            if (Carbon::now()->gt($this->created_at->addDays(1))) {
                return $column->label();
            } else {
                return $column->label();
            }
        })->sortable(); */
        $grid->column(__('admin.custom.updated_at'))->display(function () {
            $diff_day = Carbon::now()->diff($this->created_at)->days;
            $label = 'success';
            if ($diff_day > 0) {
                $msg = __("admin.custom.fxes.last_updated", ["day" => $diff_day]);
                if ($diff_day > 7) {
                    $label = 'danger';
                } else if ($diff_day > 0) {
                    $label = 'warning';
                } else {
                    $msg = __("admin.new");
                }
            } else {
                $diff_hours = Carbon::now()->diff($this->created_at)->h;
                if ($diff_hours > 0) {
                    $msg = __("admin.custom.fxes.last_updated_hours", ["hour" => $diff_hours]);
                } else {
                    $diff_minutes = Carbon::now()->diff($this->created_at)->i;
                    $msg = __("admin.custom.fxes.last_updated_minutes", ["minute" => $diff_minutes]);
                }
            }

            return '<span class="label label-' . $label . '">' . $msg . '</span>';
        })->sortable();
        $grid->column('view', __('View History'))->modal(__('admin.custom.fxes.past_foreign_history'), function ($model) {
            /* $history = $model->where('result_currency_id', $model->result_currency_id)->where('id', '!=', $model->id)->orderBy('id', 'DESC')->take(10)->get()->map(function ($history) {
                return $history->only(['id', 'fx_rate', 'created_at']);
            });
            return new Table(['Id', 'Fx Rate', 'Created At'], $history->toArray()); */
            $history = $model->where('result_currency_id', $model->result_currency_id)->where('id', '!=', $model->id)->orderBy('id', 'DESC')->take(10)->get()->map(function ($history) {
                return $history->only(['fx_rate', 'created_at']);
            });
            //dd($history->toArray());
            return new Table([__('admin.custom.fxes.fx_rate'), __('admin.custom.created_at')], $history->toArray());
        });
        //$grid->column('updated_at', __('Updated at'))->date('Y-m-d');
        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->select('result_currency_id', __('admin.custom.fxes.result_curr'))
                ->options(Currency::all()->except(1)->pluck('name', 'id'))
                ->rules('required');
            $create->decimal('fx_rate', __('admin.custom.fxes.fx_rate'))->rules('required|numeric')->placeholder(__('admin.custom.fxes.input_fx_rate'));
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Fx::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Fx());

        //$form->number('currency.currency_id', __('Currency id'));
        /* $form->select('base_currency_id', __('Base Currency'))
        ->options(Currency::all()->pluck('name', 'id'))
        ->rules('required'); */
        $form->select('result_currency_id', __('Result Currency'))
            ->options(Currency::all()->except(1)->pluck('name', 'id'))
            ->rules('required');
        $form->decimal('fx_rate', __('Fx rate'))->rules('required');
        $form->footer(function ($footer) {
            // disable `View` checkbox
            $footer->disableViewCheck();

            // disable `Continue editing` checkbox
            $footer->disableEditingCheck();

            // disable `Continue Creating` checkbox
            $footer->disableCreatingCheck();
        });
        return $form;
    }

    function getRealTime()
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

    function apiLocal()
    {
        $session = ['1700', '1200', '1130', '0900'];
        $quote = 'rm';
        foreach ($session as $value) {
            $url = 'https://api.bnm.gov.my/public/exchange-rate?session=' . $value . '&quote=' . $quote;
            $response = Http::withHeaders(
                [
                    'Accept' => 'application/vnd.BNM.API.v1+json',
                ]
            )->get($url);
            if ($response->status() != '404') {
                foreach ($response['data'] as $key => $value) {
                    if (empty(self::$local_realtime_curr_list[$value['currency_code']]) && $value['rate']['selling_rate'] != null) {
                        self::$local_realtime_curr_list[$value['currency_code']] = (1 / $value['rate']['selling_rate']) * $value['unit'];
                    }
                }
            }

            /* if ($response->status() != '404') {
                self::$local_realtime_curr_list = [$response['data'],$response['meta']];
            } */
        }
    }

    function convertBasedOnMYR($result_curr_name)
    {
        $usd_to_curr = self::$usd_to_myr;
        if (array_key_exists($result_curr_name, session('realtime_curr_list'))) {
            $bresult_curr = session('realtime_curr_list')[$result_curr_name];
            $result_curr =  $bresult_curr / $usd_to_curr;
        } else {
            $bresult_curr = 0;
            $result_curr =  "<span class='text-danger'>" . __('admin.custom.fxes.not_found') . "</span>";
        }

        return $result_curr;
    }
}
