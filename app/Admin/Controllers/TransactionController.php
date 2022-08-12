<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Transactions\Accept;
use App\Admin\Actions\Transactions\DealTransactions;
use App\Admin\Actions\Transactions\Reject;
use App\Admin\Extensions\CheckRow;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Currency;
use App\Models\Fx;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransactionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.transactions.title');
    }

    protected function path()
    {
        return asset('storage/receiptAttach');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Transaction());
        $grid->disableCreateButton();
        $grid->disableBatchActions();
        if (request()->order == 'pending') {
            $grid->model()->where('status', '=', 1);
        }
        if (request()->order == 'confirm') {
            $grid->model()->where('status', '=', 2);
        }
        if (request()->order == 'cancel') {
            $grid->model()->where('status', '=', 3);
        }
        if (request()->order == 'accept') {
            $grid->model()->where('status', '=', 4);
        }
        if (request()->order == 'reject') {
            $grid->model()->where('status', '=', 5);
        }
        $grid->model()->orderBy('created_at', 'desc');
        $grid->filter(function ($filter) {
            $filter->column(1 / 3, function ($filter) {
                $filter->like('user.name', __('admin.custom.transactions.username'));
                $filter->like('user.email', __('admin.custom.transactions.email'));
                $filter->like('from_acc', __('admin.custom.transactions.send_acc'));
                $filter->equal('from_bank1.id', __('admin.custom.transactions.send_bank'))
                    ->select(Bank::all()->pluck('name', 'id'));
            });
            $filter->column(1 / 3, function ($filter) {
                $filter->like('your_receive_acc', __('admin.custom.transactions.receive_acc'));
                $filter->equal('your_receive_bank1.id', __('admin.custom.transactions.receive_bank'))
                    ->select(Bank::all()->pluck('name', 'id'));
                $filter->equal('to_acc.id', __('admin.custom.transactions.recipient_acc'))
                    ->select(BankAccount::all()->pluck('account_no', 'id'));
                $filter->like('ref_no', __('admin.custom.transactions.reference_no'));
            });
            $filter->column(1 / 3, function ($filter) {
                $filter->equal('from_curr_id', __('admin.custom.transactions.base_curr'))
                    ->select(Currency::all()->pluck('name', 'id'));
                $filter->equal('to_curr_id', __('admin.custom.transactions.result_curr'))
                    ->select(Currency::all()->pluck('name', 'id'));
                $filter->between('fx_rate', __('admin.custom.transactions.fx_rate'));
                $filter->between('from_amount', __('admin.custom.transactions.from_amt'));
                $filter->between('to_amount', __('admin.custom.transactions.to_amt'));
                $filter->equal('status', __('admin.custom.transactions.status.title'))
                    ->select([
                        1 => __('admin.custom.transactions.status.1'),
                        2 => __('admin.custom.transactions.status.2'),
                        3 => __('admin.custom.transactions.status.3'),
                        4 => __('admin.custom.transactions.status.4'),
                        5 => __('admin.custom.transactions.status.5'),
                    ]);
            });
        });
        //$grid->expandFilter();
        /* $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->disableDelete();
            $actions->add(new Accept);
            $actions->add(new Reject);
        }); */
        $grid->disableActions();
        /* $grid->actions(function ($actions) {
            $actions->add(new App\Admin\Actions\Transactions\Accept);
        }); */

        //$grid->column('id', __('Id'));
        /* $grid->column(__('admin.custom.transactions.username') . ' + ' . __('admin.custom.transactions.email'))->display(function () {
            return '<b>' . $this->user['name'] . '</b> (' . $this->user['email'] . ')';
        }); */
        $grid->column('user.name', __('admin.custom.transactions.username'))->expand(function ($model) {
            return new Table([$this->user['name']], [
                [__('admin.custom.transactions.email') . ':  <b>' . $this->user['email'] . '</b>'],
                [__('admin.custom.transactions.send_acc') . ':  <b>' . $this->from_acc . '</b>'],
                [__('admin.custom.transactions.send_bank') . ':  <b>' . $this->from_bank['name'] . '</b>'],
                [__('admin.custom.transactions.receive_acc') . ':   <b>' . $this->your_receive_acc . '</b>'],
                [__('admin.custom.transactions.receive_bank') . ':   <b>' . $this->your_receive_bank['name'] . '</b>'],
            ]);
        });
        //$grid->column('user.name', __('admin.custom.transactions.username'))->color('#535657');
        //$grid->column('user.email', __('admin.custom.transactions.email'))->color('#535657');
        /* $grid->column(__('admin.custom.transactions.send_acc_bank'))->display(function () {
            return $this->from_acc . ' (' . $this->from_bank['name'] . ')';
        })->color('brown');
        $grid->column('from_acc', __('admin.custom.transactions.receive_acc_bank'))->display(function () {
            return $this->your_receive_acc . ' (' . $this->your_receive_bank['name'] . ')';
        })->color('brown'); */
        $grid->column('receipt_img_path', __('admin.custom.transactions.receipt'))->lightbox([
            'server' => '../receiptAttach',
            'width' => 50,
            'height' => 50,
        ]);
        /* $grid->column('to_acc_id->account_no', __('admin.custom.transactions.recipient_acc_bank'))->expand(function ($model) {
            return new Table([$this->to_acc_id['account_no']], [
                [__('admin.custom.transactions.recipient_acc') . ':  <b>' . $this->to_acc_id['account_no'] . '</b>'],
                [__('admin.custom.transactions.recipient_bank') . ':  <b>' . $this->to_acc_id['bank_name'] . '</b>'],
                [__('admin.custom.transactions.reference_no') . ':  <b>' . $this->ref_no . '</b>'],
            ]);
        }); */
        $grid->column('to_acc_id->account_no',__('admin.custom.transactions.recipient_acc'));
        $grid->column('to_acc_id->bank_name',__('admin.custom.transactions.recipient_bank'));/* 
        $grid->column(__('admin.custom.transactions.recipient_bank'))->display(function () {
            return $this->to_acc_id['account_no'] . ' (' . Bank::find($this->to_acc_id['bank_id'])->name . ')';
        }); */
        $grid->column('ref_no', __('admin.custom.transactions.reference_no'));
        $grid->column('recipient_receipt_img_path', __('admin.custom.transactions.recipient_receipt'))->lightbox([
            'server' => '../recipientReceiptAttach',
            'width' => 50,
            'height' => 50,
        ]);
        //$grid->column('from_amount', __('admin.custom.transactions.from_amt'));
        $grid->column(__('admin.custom.transactions.from_amt'))->display(function () {
            return '<b>' . $this->from_amount . '</b> <p>(' . $this->from_curr_id['name'] . ')';
        });
        $grid->column(__('admin.custom.transactions.fx_rate'))->display(function () {
            return '<b>' . $this->fx_rate . '</b>';
        });
        $grid->column(__('admin.custom.transactions.to_amt'))->display(function () {
            return '<b>' . $this->to_amount . '</b> <p>(' . $this->to_curr_id['name'] . ')';
        });
        //$grid->column('to_amount', __('admin.custom.transactions.to_amt'));
        $grid->column('status', __('admin.custom.transactions.status.title'))->using([
            1 => __('admin.custom.transactions.status.1'),
            2 => __('admin.custom.transactions.status.2'),
            3 => __('admin.custom.transactions.status.3'),
            4 => __('admin.custom.transactions.status.4'),
            5 => __('admin.custom.transactions.status.5'),
        ])->label([
            1 => 'default',
            2 => 'info',
            3 => 'warning',
            4 => 'success',
            5 => 'danger',
        ])->sortable();
        $grid->column('created_at', __('admin.custom.created_at'))->sortable();
        $grid->column('updated_at', __('admin.custom.updated_at'))->sortable();
        //$grid->column(__('admin.custom.transactions.action'))->action(new DealTransactions());
        $grid->column(1, __('admin.custom.transactions.accept'))->display(function ($grid, $column) {
            //dd($column);
            if ($this->status == 2) {
                return $column->action(new Accept());
            } else {
                return "<span class='btn btn-sm btn-success' disabled><i class='fa fa-check'></i></span>";
            }
        });
        $grid->column(2, __('admin.custom.transactions.reject'))->display(function ($grid, $column) {
            //dd($column);
            if ($this->status == 2) {
                return $column->action(new Reject());
            } else {
                return "<span class='btn btn-sm btn-danger' disabled><i class='fa fa-ban'></i></span>";
            }
        });
        /* $grid->column(__('admin.custom.transactions.accept'))->display(function ($grid, $column) {
            //dd($column);
            return $column->action(new Accept());
            if ($this->status == 2) {
                return $column->action(new Accept());
            } else {
                return "";
            }
        });
        $grid->column(__('admin.custom.transactions.reject'))->display(function ($grid, $column) {
            //dd($column);
            return $column->action(new Reject());
            if ($this->status == 2) {
                return $column->action(new Reject());
            } else {
                return "";
            }
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
        $show = new Show(Transaction::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Transaction());
        $form->select('user_id', __('admin.custom.transactions.username'))
            ->options(User::all()->pluck('email', 'id'))
            ->rules('required');
        $form->text('from_acc', __('admin.custom.transactions.send_acc'))->rules('required');
        //$form->number('to_acc_id', __('To acc id'));
        //$form->text('from_bank', __('From bank'));
        $form->select('from_bank', __('admin.custom.transactions.send_bank'))
            ->options(Bank::all()->pluck('name', 'id'))
            ->rules('required');
        $form->text('your_receive_acc', __('admin.custom.transactions.receive_acc'))->rules('required');
        $form->select('your_receive_bank', __('admin.custom.transactions.receive_bank'))
            ->options(Bank::all()->pluck('name', 'id'))
            ->rules('required');
        $form->select('to_acc_id', __('admin.custom.transactions.recipient_acc'))
            ->options(BankAccount::all()->pluck('account_no', 'id'))
            ->rules('required');
        //$form->number('to_bank_id', __('To bank id'));
        /* $form->select('to_bank_id', __('Receiving Bank'))
        ->options(Bank::all()->pluck('name', 'id'))
        ->rules('required'); */
        ////////////////
        //$get = Fx::with('base_currency')->with('result_currency')->first();
        //return $get->base_currency->name;
        ///////////////////
        //echo($form->model());
        /* $fx_banks = $form->model()->with('base_currency')->with('result_currency')->get();
        foreach ($fx_banks as $p) {
            $result[]=$p->base_currency->name." => ".$p->result_currency->name;
        }
        echo($result); */
        //$fx_banks = $form->model()->with('base_currency')->with('result_currency')->get();

        /* $form->select('fx_id', __('Foreign Exchange Id'))
        ->options(Fx::all()->pluck('id','id'))
        ->rules('required'); */
        $form->select('from_curr_id', __('admin.custom.transactions.base_curr'))
            ->options(Currency::all()->pluck('name', 'id'))
            ->rules('required')->disable();
        $form->select('to_curr_id', __('admin.custom.transactions.result_curr'))
            ->options(Currency::all()->pluck('name', 'id'))
            ->rules('required');
        $form->decimal('fx_rate', __('Fx rate'))->rules('required')->default(0.00);
        $form->decimal('from_amount', __('From amount'))->rules('required')->default(0.00);
        $form->decimal('to_amount', __('To amount'))->rules('required')->default(0.00);
        /* if ($form->isEditing()) {
            $form->decimal('to_amount', __('To amount'))->rules('required')->default(0.00)->readonly();
        } */
        //$form->number('status', __('Status'))->default(1);
        $form->text('ref_no', __('Reference No'))->rules('required');
        $form->radio('status', __('Status'))->options([
            /* 1 => 'Pending',
            2 => 'Confirm Transferred',
            3 => 'Cancelled', */
            4 => 'Accepted',
            5 => 'Rejected',
        ])->default(1);
        $form->saving(function (Form $form) {
            $form->to_amount = $form->from_amount * $form->fx_rate;
            if ($form->status != $form->model()->status) {
                $order = '<b>Order #' . str_pad($form->id, 5, '0', STR_PAD_LEFT) . '</b>';
                if ($form->status == 4) {
                    $message = 'Our staff has accepted the transaction of ' . $order . ' successfully! It might takes time dues to huge amounts of users using our platform! You may check your account whether is received! Thanks for using our service!';
                } else if ($form->status == 5) {
                    $message = 'Your ' . $order . ' has been rejected!';
                }
                $notification = Notification::create([
                    'transasction_id' => $form->model()->id,
                    'message' => $message,
                ]);
            }
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

    public function transactionNotification(Request $request)
    {
        $count = Transaction::where('status', '=', 2)->count();
        //        return $count;
        // 处理逻辑
        $getCount = session()->get('count');

        if ($count > $getCount) {
            session()->put('count', $count); // 存session
            return ['code' => 200, 'msg' => __('admin.custom.transactions.new_order_arrived'), 're' => $count];
        }
        // 不成立的话则存最新的值
        session()->put('count', $count);
        return ['code' => 201, 're' => $count];
    }
}
