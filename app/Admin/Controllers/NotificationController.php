<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\deleteAction;
use App\Models\Notification;
use App\Models\Reason;
use App\Models\Transaction;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\MessageBag;

class NotificationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.notifications.title');
    }

    protected function getLocale()
    {
        $locale = App::getLocale();
        if (str_contains($locale, 'zh')) $locale = 'zh';
        return $locale;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Notification());
        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->like('user.name', __('admin.custom.notifications.username'));
                $filter->like('user.email', __('admin.custom.notifications.email'));
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->like('transasction.ref_no', __('admin.custom.notifications.order_id'));
                $filter->equal('message_type', __('admin.custom.notifications.type.title'))
                    ->select([
                        1 => __('admin.custom.notifications.type.1'),
                        2 => __('admin.custom.notifications.type.2'),
                        3 => __('admin.custom.notifications.type.3'),
                        4 => __('admin.custom.notifications.type.4'),
                        5 => __('admin.custom.notifications.type.5'),
                        6 => __('admin.custom.notifications.type.6'),
                        7 => __('admin.custom.notifications.type.7'),
                        8 => __('admin.custom.notifications.type.8')
                    ]);
                $filter->equal('status', __('admin.custom.notifications.status.title'))
                    ->select([
                        1 => __('admin.custom.notifications.status.1'),
                        2 => __('admin.custom.notifications.status.2'),
                    ]);
            });
        });
        /* $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        }); */
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        //$grid->disableActions();
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('id', __('Id'));
        $grid->column('user.name', __('admin.custom.notifications.username'));
        $grid->column('user.email', __('admin.custom.notifications.email'));

        $grid->column('transasction.ref_no', __('admin.custom.notifications.order_id'))->display(function ($grid) {
            if ($grid) {
                return '#' . $grid;
            } else {
                return '-';
            }
        });
        $grid->column('message_type', __('admin.custom.notifications.type.title'))->using([
            1 => __('admin.custom.notifications.type.1'),
            2 => __('admin.custom.notifications.type.2'),
            3 => __('admin.custom.notifications.type.3'),
            4 => __('admin.custom.notifications.type.4'),
            5 => __('admin.custom.notifications.type.5'),
            6 => __('admin.custom.notifications.type.6'),
            7 => __('admin.custom.notifications.type.7'),
            8 => __('admin.custom.notifications.type.8')
        ])->label([
            1 => 'default',
            2 => 'info',
            3 => 'warning',
            4 => 'success',
            5 => 'danger',
            6 => 'danger',
            7 => 'danger',
            8 => 'primary',
        ]);
        $grid->column(__('admin.custom.notifications.reason'))->display(function () {
            if ($this->reason) {
                return $this->reason->message[self::getLocale()];
            } else {
                return '-';
            }
        });

        $grid->column('status', __('admin.custom.notifications.status.title'))->using([
            1 => __('admin.custom.notifications.status.1'),
            2 => __('admin.custom.notifications.status.2'),
        ])->dot([
            1 => 'warning',
            2 => 'success'
        ]);
        /* $grid->column('status', __('admin.custom.notifications.status.title'))->editable('select', [
            1 => __('admin.custom.notifications.status.1'),
            2 => __('admin.custom.notifications.status.2'),
        ]); */
        //$grid->column('status', __('Status'));
        $grid->column('created_at', __('admin.custom.created_at'))->sortable();
        $grid->column('updated_at', __('admin.custom.updated_at'));
        //$grid->column('Action')->action(deleteAction::class);

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
        $show = new Show(Notification::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        //return Notification::all()->pluck('transasction_id', 'transasction_id');
        $form = new Form(new Notification());
        $default_mode = 1;
        if ($form->isEditing()) {
            $id = request()->route()->parameter('notification');
            $model = $form->model()->find($id);
            if ($model->transasction_id != -1) {
                $default_mode = 2;
            }
        }
        $form->radio('type', __('admin.custom.notifications.category.type'))
            ->options([
                1 => __('admin.custom.notifications.category.1'),
                2 => __('admin.custom.notifications.category.2'),
            ])->when(2, function (Form $form) {
                $form->select('user_id', __('admin.custom.notifications.email'))
                    ->options(User::all()->pluck('email', 'id'))
                    ->rules('required');
                $form->select('transasction_id', __('admin.custom.notifications.order_id'))
                    ->options(function () {
                        $array = Transaction::get('id');
                        $result_array = [];
                        foreach ($array as $key => $value) {
                            $result_array[$value['id']] = __('admin.custom.notifications.order', ['transaction_id' => str_pad($value['id'], 5, '0', STR_PAD_LEFT)]);
                            //'Order #' . str_pad($value['id'], 5, '0', STR_PAD_LEFT);
                        }
                        return $result_array;
                    });
                $form->select('message_type', __('admin.custom.notifications.type.title'))
                    ->options([
                        1 => __('admin.custom.notifications.type.1'),
                        2 => __('admin.custom.notifications.type.2'),
                        3 => __('admin.custom.notifications.type.3'),
                        4 => __('admin.custom.notifications.type.4'),
                        5 => __('admin.custom.notifications.type.5'),
                        6 => __('admin.custom.notifications.type.6'),
                        7 => __('admin.custom.notifications.type.7')
                    ])
                    ->rules('required');
                $form->select('reason_id', __('admin.custom.notifications.reason'))
                    ->options(function () {
                        $array = Reason::all();
                        $result_array = [];

                        foreach ($array as $key => $value) {
                            $result_array[$value['id']] = $value->message[self::getLocale()];
                        }
                        return $result_array;
                    })->default(-1);
            })->when(1, function (Form $form) {
                $user_arr[-1] = __('admin.custom.notifications.all');
                foreach (User::all()->pluck('email', 'id') as $key => $value) {
                    $user_arr[$key] = $value;
                }
                $form->select('user_id', __('admin.custom.notifications.email'))
                    ->options($user_arr)
                    ->rules('required');
                $form->select('message_type', __('admin.custom.notifications.type.title'))
                    ->options([
                        8 => __('admin.custom.notifications.type.8')
                    ])
                    ->rules('required')->default(8);
                $form->select('reason_id', __('admin.custom.notifications.reason'))
                    ->options(function () {
                        $array = Reason::all();
                        $result_array = [];

                        foreach ($array as $key => $value) {
                            $result_array[$value['id']] = $value->message[self::getLocale()];
                        }
                        return $result_array;
                    })->default(-1)->rules('required');
            })->default($default_mode);

        /* $form->select('transasction_id', __('Transasction id'))
            ->options(function () {
                $array = Notification::has('transasction')->get()
                    ->pluck('transasction_id', 'transasction_id');
                $result_array = [];
                foreach ($array as $key => $value) {
                    $result_array[$key] = '#' . str_pad($value, 5, '0', STR_PAD_LEFT);
                }
                return $result_array;
            })
            ->rules('required'); */
        //$form->number('transasction_id', __('Transasction id'));
        //$form->text('message', __('Message'));
        $form->hidden('status', __('admin.custom.notifications.status.title'))->options([
            1 => __('admin.custom.notifications.status.1'),
            2 => __('admin.custom.notifications.status.2'),
        ])->default(1);

        $form->ignore('type');

        $form->saving(function (Form $form) {
            if ($form->user_id == -1) {
                $user = User::all();
                foreach ($user as $key => $value) {
                    $notification = Notification::create([
                        'user_id' => $value->id,
                        'transasction_id' => -1,
                        'message_type' => $form->message_type,
                        'reason_id' => $form->reason_id,
                        'status' => 1,
                    ]);
                }
                admin_toastr(__('admin.custom.notifications.save_succeeded'));
                return redirect('/admin/notifications');
            }
            if (!$form->transasction_id) {
                $form->transasction_id = -1;
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
}
