<?php

namespace App\Admin\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Country;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\Log;

class BankAccountController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.bank_accounts.title');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BankAccount());
        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->like('account_no', __('admin.custom.bank_accounts.acc_no'));
                $filter->like('bank.name', __('admin.custom.bank_accounts.bank'));
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->equal('status', __('admin.custom.bank_accounts.status.title'))
                    ->select([
                        1 => __('admin.custom.bank_accounts.status.on'),
                        2 => __('admin.custom.bank_accounts.status.off'),
                    ]);
                $filter->date('created_at', __('admin.custom.created_at'));
                $filter->date('updated_at', __('admin.custom.updated_at'));
            });
        });
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->column('id', __('Id'));
        $grid->column('account_no', __('admin.custom.bank_accounts.acc_no'));
        $grid->column('bank.name', __('admin.custom.bank_accounts.bank'));
        //$grid->column('bank.country_id', __('admin.custom.bank_accounts.bank'));
        $grid->column(__('admin.custom.banks.country'))->modal(__('admin.custom.banks.country'), function ($model) {
            $country_id = $model->bank->country_id;
            sort($country_id);
            $country_list = array();
            foreach ($country_id as $key => $value) {
                $select_country = Country::find($value)->only('id', 'name', 'created_at');
                array_push($country_list, $select_country);
            }
            return new Table([__('Id'), __('admin.custom.countries.name'), __('admin.custom.created_at')], $country_list);
        });
        $states = [
            'on' => ['value' => 1, 'text' => __('admin.custom.bank_accounts.status.on'), 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => __('admin.custom.bank_accounts.status.off'), 'color' => 'default'],
        ];
        $grid->column('status', __('admin.custom.bank_accounts.status.title'))->switch($states);

        //$grid->column('status', __('Status'))->switch($states); 

        /* $grid->column('status', __('Status'))->display(function ($title, $column) {
            // If the value of the status field of this column is equal to 1, directly display the title field
            If ($this->status == 1) {
                return "<b style='color:green;'>Activating</b>";
            }elseif($this->status == 2) {
                return "<b style='color:red;'>Closing</b>";
            }else{
                return "<del style='color:grey;'>Unfound status</del>";
            }
            
            // Otherwise it is displayed as editable
            //return $column->editable('select', [1 => 'option1', 2 => 'option2', 3 => 'option3']);
        }); */
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
        $show = new Show(BankAccount::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new BankAccount());
        //$form->setAction('/admin/bank-accounts');
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
        $form->text('account_no', __('admin.custom.bank_accounts.acc_no'))->rules('required');
        //$form->number('bank_id', __('Bank id'));
        $states = [
            'on' => ['value' => 1, 'text' => __('admin.custom.bank_accounts.status.on'), 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => __('admin.custom.bank_accounts.status.off'), 'color' => 'default'],
        ];
        $form->switch('status', __('admin.custom.bank_accounts.status.title'))->states($states);
        $form->select('bank_id', __('admin.custom.bank_accounts.bank'))
            ->options(Bank::all()->pluck('name', 'id'))
            ->rules('required');
        $form->submitted(function () use ($form) {
            if ($form->model()->status) {
                if ($form->model()->status == 1 && $form->model()->where('status', '1')->count() == 1)
                    throw new \Exception(__('admin.custom.bank_accounts.form-hint'));
            }
        });
        /* $form->saved(function () use ($form) {
            if ($form->model()->where('status', '1')->count() == 0) {
                $form->model()->status = 1;
                throw new \Exception('At least 1 active bank account...');
            }
        }); */
        return $form;
    }
}
