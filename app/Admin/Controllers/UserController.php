<?php

namespace App\Admin\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Widgets\Table;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title(){
        return __('admin.custom.users.title');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());
        $grid->disableBatchActions();
        $grid->model()->orderBy('created_at', 'desc');
        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->like('name', __('admin.custom.users.name'));
                $filter->like('email', __('admin.custom.users.email'));
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->date('email_verified_at', __('admin.custom.users.email_verified_at'));
                $filter->date('created_at', __('admin.custom.created_at'));
                $filter->date('updated_at', __('admin.custom.updated_at'));
            });
        });
        /* $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        }); */
        $grid->disableCreateButton();
        $grid->disableActions();
        //$grid->column('id', __('Id'));
        $grid->column('name', __('admin.custom.users.name'));
        $grid->column('email', __('admin.custom.users.email'));
        $grid->column('email_verified_at', __('admin.custom.users.email_verified_at'));
        //$grid->column('password', __('Password'));
        //$grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('admin.custom.created_at'));
        $grid->column('updated_at', __('admin.custom.updated_at'));
        /* $grid->column('View')->modal('Past Foreign Exchange', function ($model) {
            $transaction = (new Transaction())::where('user_id',$model->id)->orderBy('id','DESC')->get();
            $history = (new Transaction())::with('from_bank1')->where('user_id',$model->id)->orderBy('id','DESC')->get()->map(function ($history) {
                return $history->only(['from_acc','from_bank','to_acc_id','to_bank_id','fx_id','fx_rate','from_amount','to_amount','status']);
            });

            return new Table(['User Account','User Bank','Receiving Account','Receiving Bank','Foreign Exchange ID','Foreign Exchange Rate','Base Amount','Result Amount','Status'], $history->toArray());
        }); */
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
        $show = new Show(User::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('admin.custom.users.name'));
        $form->email('email', __('admin.custom.users.email'));
        $form->datetime('email_verified_at', __('admin.custom.users.email_verified_at'));
        //$form->password('password', __('Password'));
        //$form->text('remember_token', __('Remember token'));
        $form->saving(function (Form $form) {
            $form->password = Hash::make($form->password);
        });
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

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
}
