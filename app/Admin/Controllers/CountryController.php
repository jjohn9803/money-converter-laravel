<?php

namespace App\Admin\Controllers;

use App\Models\Country;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CountryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.countries.title');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Country());
        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->like('name', __('admin.custom.countries.name'));
                $filter->like('alpha_2_code', __('admin.custom.countries.alpha_2_code'));
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->date('created_at', __('admin.custom.created_at'));
                $filter->date('updated_at', __('admin.custom.updated_at'));
            });
        });
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->model()->orderBy('id', 'desc')->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc');
        $grid->column('id', __('Id'));
        $grid->column('name', __('admin.custom.countries.name'));
        $grid->column('alpha_2_code', __('admin.custom.countries.alpha_2_code'));
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
        $show = new Show(Country::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Country());
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
        $form->text('name', __('admin.custom.countries.name'))->rules('required');
        $form->text('alpha_2_code', __('admin.custom.countries.alpha_2_code'))->help("<a href='https://www.iban.com/country-codes' target='_blank'>" . __('admin.custom.countries.form-hint') . "</a>")->rules('required');

        $form->saving(function () use ($form) {
            $form->alpha_2_code = strtoupper($form->alpha_2_code);
        });

        return $form;
    }
}
