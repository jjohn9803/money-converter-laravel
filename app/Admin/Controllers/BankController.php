<?php

namespace App\Admin\Controllers;

use App\Models\Bank;
use App\Models\Country;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\Log;

class BankController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.banks.title');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Bank());
        $grid->model()->orderBy('id', 'desc')->orderBy('created_at', 'desc');
        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->like('name', __('admin.custom.banks.bank_name'));
                //$filter->like('country.name', '__('Country')');
                $filter->equal('country_id', __('admin.custom.banks.country'))
                    ->select(Country::all()->pluck('name', 'id'));
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->date('created_at', __('admin.custom.created_at'));
                $filter->date('updated_at', __('admin.custom.updated_at'));
            });
        });
        $grid->actions(function ($actions) {
            $actions->disableView();
            //$actions->disableEdit();
        });
        //$grid->column('id', __('Id'));
        $grid->column('name', __('admin.custom.banks.bank_name'));
        $grid->column(__('admin.custom.banks.country'))->modal(__('admin.custom.banks.country'), function ($model) {
            $country_id = $model->country_id;
            if($country_id != null){
                sort($country_id);
                $country_list = array();
                foreach ($country_id as $key => $value) {
                    $select_country = Country::find($value)->only('id', 'name', 'created_at');
                    array_push($country_list, $select_country);
                }
                return new Table([__('Id'), __('admin.custom.countries.name'), __('admin.custom.created_at')], $country_list);
            }
            return '';
        });
        /* $grid->column(__('admin.custom.banks.country'))->display(function () {
            return $this->country->name;
        }); */
        /* $grid->column('name', __('Bank Name'))->editable();
        $grid->column('country_id')->editable('select', Country::all()->pluck('name', 'id'),); */
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
        $show = new Show(Bank::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Bank());
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
        $form->text('name', __('admin.custom.banks.bank_name'))->rules('required');
        //$form->number('country_id', __('Country id'));
        $form->multipleSelect('country_id', __('admin.custom.banks.country'))
            ->options(Country::all()->pluck('name', 'id'))
            ->rules('required');
        /* $form->list('country_id'); */
        //$form->multipleSelect('country_id', __('Country id'))->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
        /* $form->embeds('message', __('Message'), function ($form) {
            $form->text('en', __('admin.custom.reason.en'))->rules('required');
            $form->text('zh', __('admin.custom.reason.zh-CN'))->rules('required');
        }); */
        /* $form->select('country_id', __('admin.custom.banks.country'))
            ->options(Country::all()->pluck('name', 'id'))
            ->rules('required'); */

        $form->submitted(function () use ($form) {
            /* if ($form->model()->status) {
                if ($form->model()->status == 1 && $form->model()->where('status', '1')->count() == 1){

                }
            } */
        });

        $form->saving(function () use ($form) {
            $saving_curr = $form->country_id;
            $json_curr = "[";
            foreach ($saving_curr as $key => $value) {
                if (!empty($value)) {
                    $json_curr .= $value . ",";
                }
            }
            $json_curr = substr($json_curr, 0, strlen($json_curr) - 1) . "]";
            $form->model()->country_id = $json_curr;
        });
        return $form;
    }
}
