<?php

namespace App\Admin\Controllers;

use App\Models\Reason;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ReasonController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.reason.title');
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
        $grid = new Grid(new Reason());
        $grid->model()->orderBy('created_at', 'desc');
        //$grid->disableRowSelector();
        $grid->disableBatchActions();
        /* $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        }); */
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        /* $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('message', __('Message'));
        });
        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->like('message', __('English Message'));
                //$filter->like('message', __('Mandarin Message'));
            });
        }); */
        $grid->filter(function ($filter) {
            $filter->like('message->en', __('admin.custom.reason.en'));
            $filter->like('message->zh', __('admin.custom.reason.zh-CN'));
        });
        //$grid->disableActions();
        //$grid->disableCreateButton();
        //$grid->column('id', __('Id'));
        $grid->column('message->en', __('admin.custom.reason.en'));
        $grid->column('message->zh', __('admin.custom.reason.zh-CN'));
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
        $show = new Show(Reason::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Reason());
        //$form->keyValue('message', __('Message'))->rules('required');
        $form->text('en', __('admin.custom.reason.en'))->rules('required');
        $form->text('zh', __('admin.custom.reason.zh-CN'))->rules('required');
        //$form->hidden('message')->default('hahahahah');
        $form->embeds('message', '', function ($form) {
        })->style('display', 'none');
        $form->submitted(function (Form $form) {
            $form->ignore('en');
            $form->ignore('zh');
        });
        $form->saving(function (Form $form) {
            $form->message = array('en' => request()->en, 'zh' => request()->zh);
            //throw new \Exception("Error Processing Request", 1);
            //Log::debug(array('en' => request()->en, 'zh' => request()->zh));
        });
        /* $form->saving(function($form){
            throw new \Exception($form->model());
            
        }); */
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
