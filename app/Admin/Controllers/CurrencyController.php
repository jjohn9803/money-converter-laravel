<?php

namespace App\Admin\Controllers;

use App\Models\Country;
use App\Models\Currency;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Hamcrest\Type\IsObject;
use Illuminate\Support\Facades\Http;
use Nette\Utils\Arrays;

class CurrencyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.currencies.title');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Currency());
        $grid->model()->orderBy('id', 'desc')->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc');
        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->like('name', __('admin.custom.currencies.name'));
                $filter->like('country.name', __('admin.custom.currencies.country'));
                $filter->between('min_amt', __('admin.custom.currencies.min_amt'));
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->between('max_amt', __('admin.custom.currencies.max_amt'));
                $filter->date('created_at', __('admin.custom.created_at'));
                $filter->date('updated_at', __('admin.custom.updated_at'));
            });
        });
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        //$grid->column('id', __('Id'));
        $grid->column('name', __('admin.custom.currencies.name'));
        //$grid->column('country_id', __('Country id'));
        $grid->column('country.name', __('admin.custom.currencies.country'));
        /* $grid->column('min_amt', __('Min Amount'))->editable();
        $grid->column('max_amt', __('Max Amount'))->editable(); */
        $grid->column('min_amt', __('admin.custom.currencies.min_amt'));
        $grid->column('max_amt', __('admin.custom.currencies.max_amt'));
        $grid->column('created_at', __('admin.custom.created_at'));
        $grid->column('updated_at', __('admin.custom.updated_at'));

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
        $show = new Show(Currency::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Currency());
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            /* $footer->disableReset();
            $footer->disableSubmit(); */
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        //dd(self::getCurrencyName());
        //dd(Country::all()->pluck('name', 'id'));
        $getCurrencyWithCountry = self::getCurrencyNameWithCountry();
        if ($getCurrencyWithCountry) {
            $form->select('name', __('admin.custom.currencies.name'))
                ->options($getCurrencyWithCountry)
                ->help("<a href='https://www.sport-histoire.fr/en/Geography/Currencies_countries_of_the_world.php' target='_blank'>" . __('admin.custom.currencies.form-hint') . "</a>")
                ->rules('required');
        } else {
            $form->text('name', __('admin.custom.currencies.name'))->help("<a href='https://www.sport-histoire.fr/en/Geography/Currencies_countries_of_the_world.php' target='_blank'>" . __('admin.custom.currencies.form-hint') . "</a>")->rules('required');
        }
        $form->select('country_id', __('admin.custom.currencies.country'))
            ->options(Country::all()->pluck('name', 'id'))
            ->rules('required');
        $form->currency('min_amt', __('admin.custom.currencies.min_amt'));
        $form->currency('max_amt', __('admin.custom.currencies.max_amt'));
        $form->saving(function (Form $form) {
            if ($form->min_amt) {
                if (!is_numeric($form->min_amt)) {
                    throw new \Exception();
                }
                $form->min_amt = floatval($form->min_amt);
            }
            if ($form->max_amt) {
                if (!is_numeric($form->max_amt)) {
                    throw new \Exception();
                }
                $form->max_amt = floatval($form->max_amt);
            }
            $form->name = strtoupper($form->name);
        });
        return $form;
    }

    function getCurrencyNameWithCountry()
    {
        try {
            $response = Http::withHeaders(
                [
                    'X-RapidAPI-Key' => 'e048c447eemsh6d3d83643dbb2b0p1ed171jsn66126b55cb3f',
                    'X-RapidAPI-Host' => 'codesofcountry.p.rapidapi.com',
                ]
            )->get('https://codesofcountry.p.rapidapi.com/countries');
            $array_currency = $response['countries'];
            $result_currency = (object)[];
            foreach ($array_currency as $key => $value) {
                $country = '';
                $iso_alpha_two = '';
                $currency_code = '';
                foreach ($value as $key2 => $value2) {
                    if ($key2 == 'country') {
                        $country = $value2;
                    }
                    if ($key2 == 'iso_alpha_two') {
                        $iso_alpha_two = $value2;
                    }
                    if ($key2 == 'currency_code') {
                        $currency_code = $value2;
                    }
                }
                $result_currency->$currency_code = $currency_code . ' (' . $country . ')';
            }
            return $result_currency;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
