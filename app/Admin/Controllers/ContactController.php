<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\deleteAction;
use App\Models\Contact;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ContactController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.contacts.title');
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Contact());
        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->url('contact_link', __('admin.custom.contacts.contact_link'));
            $create->select('type', __('admin.custom.contacts.type.title'))
                ->options([
                    1 => __('admin.custom.contacts.type.1'),
                    2 => __('admin.custom.contacts.type.2'),
                    3 => __('admin.custom.contacts.type.3'),
                    4 => __('admin.custom.contacts.type.4'),
                    5 => __('admin.custom.contacts.type.5'),
                ])
                ->rules('required');
        });
        $grid->column('id', __('Id'));
        $grid->column('contact_link', __('admin.custom.contacts.contact_link'))->editable()->width(350);
        $grid->column('type', __('admin.custom.contacts.type.title'))->radio(
            [
                1 => __('admin.custom.contacts.type.1'),
                2 => __('admin.custom.contacts.type.2'),
                3 => __('admin.custom.contacts.type.3'),
                4 => __('admin.custom.contacts.type.4'),
                5 => __('admin.custom.contacts.type.5'),
            ]
        );
        $grid->column('status', __('admin.custom.contacts.status.title'))->radio([
            1 => __('admin.custom.contacts.status.1'),
            2 => __('admin.custom.contacts.status.2'),
            3 => __('admin.custom.contacts.status.3'),
        ]);
        
        $grid->column('created_at', __('admin.custom.created_at'));
        $grid->column('updated_at', __('admin.custom.updated_at'));
        $grid->column(__('admin.action'))->action(deleteAction::class);
        $grid->disableActions();
        $grid->disableCreateButton();
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
        $show = new Show(Contact::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Contact());

        $form->text('contact_link', __('admin.custom.contacts.contact_link'));
        $form->select('type', __('admin.custom.contacts.type.title'))
            ->options([
                1 => __('admin.custom.contacts.type.1'),
                2 => __('admin.custom.contacts.type.2'),
                3 => __('admin.custom.contacts.type.3'),
                4 => __('admin.custom.contacts.type.4'),
                5 => __('admin.custom.contacts.type.5'),
            ])
            ->rules('required');
        $form->radio('status', __('admin.custom.contacts.status.title'))->options([
            1 => __('admin.custom.contacts.status.1'),
            2 => __('admin.custom.contacts.status.2'),
            3 => __('admin.custom.contacts.status.3'),
        ]);
        $form->saving(function (Form $form) {
            /* $form->to_amount = $form->from_amount * $form->fx_rate;
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
            } */
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
