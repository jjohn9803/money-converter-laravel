<?php

namespace App\Admin\Controllers;

use App\Models\HomePage;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class HomePageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected function title()
    {
        return __('admin.custom.homepage.title');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HomePage());
        $grid->disableBatchActions();
        //$grid->column('id', __('Id'));
        $grid->column('id', __('admin.custom.homepage.name.title'))->using([
            1 => __('admin.custom.homepage.name.1'),
            2 => __('admin.custom.homepage.name.2'),
            3 => __('admin.custom.homepage.name.3'),
            4 => __('admin.custom.homepage.name.4'),
            5 => __('admin.custom.homepage.name.5'),
            6 => __('admin.custom.homepage.name.6'),
            7 => __('admin.custom.homepage.name.7'),
            8 => __('admin.custom.homepage.name.8'),
            9 => __('admin.custom.homepage.name.9'),
            10 => __('admin.custom.homepage.name.10'),
            11 => __('admin.custom.homepage.name.11'),
        ])->style('text-align:center;');
        //$grid->column('name',__('admin.custom.homepage.name.title'));
        /* $grid->column('view', __('admin.custom.homepage.value.title'))->modal(__('admin.custom.homepage.value.title'), function ($model) {
            $array = $model->where('id', '=', $model->id)->orderBy('id', 'DESC')->take(10)->get('value');
            return new Table($array);
        }); */
        /* $grid->column(__('admin.custom.homepage.value.title'))->modal(__('admin.custom.homepage.value.title'), function ($model) {

            $comments = $model->comments()->take(10)->get()->map(function ($comment) {
                return $comment->only(['id', 'content', 'created_at']);
            });
        
            return new Table(['ID', 'content', 'release time'], $comments->toArray());
        }); */
        /* $grid->column(__('admin.custom.homepage.value.en'))->display(function () {
            if (isset($this->value['boolean']) && $this->value['boolean'] == 'Maintenance') {
                return 'hello';
            } else if (isset($this->value['boolean']) && $this->value['boolean'] == 'Maintenance') {
                return 'lol';
            }else{

            }
        }); */
        $grid->column('value', __('admin.custom.homepage.value.title'))->display(function ($grid, $column) {
            try {
                return '<b>' . __('admin.custom.homepage.value.en') . '</b>: ' . $this->value['en'] . '<br><b>' . __('admin.custom.homepage.value.zh-CN') . '</b>: ' . $this->value['zh'];
            } catch (\Throwable $th) {
                try {
                    if ($this->value['start'] == $this->value['end']) {
                        return __('admin.custom.homepage.wh-every');
                    } else {
                        return  $this->value['start'] . '~' . $this->value['end'];
                    }
                } catch (\Throwable $th) {
                    try {
                        if ($this->value['boolean']) {
                            return __('admin.custom.homepage.maintenance-on');
                        } else {
                            return __('admin.custom.homepage.maintenance-off');
                        }
                    } catch (\Throwable $th) {
                        return $this->value['value'];
                    }
                }
            }
        });
        /* $grid->column('value->en', __('admin.custom.homepage.value.en'));
        $grid->column('value->zh', __('admin.custom.homepage.value.zh-CN')); */
        $grid->column('created_at', __('admin.custom.created_at'));
        $grid->column('updated_at', __('admin.custom.updated_at'));
        $grid->column('')->display(function () {
            return '<a href="' . url()->current() . '/' . $this->id . '/edit" target="_self"><i class="fa fa-pencil-square-o"></i></a>';
        });
        /* $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
            $actions->disableEdit();
        }); */
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
        $show = new Show(HomePage::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HomePage());

        $form->text('name', __('admin.custom.homepage.name.title'))->readonly();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->footer(function ($footer) {

            // disable `View` checkbox
            $footer->disableViewCheck();

            // disable `Continue editing` checkbox
            $footer->disableEditingCheck();

            // disable `Continue Creating` checkbox
            $footer->disableCreatingCheck();
        });
        //$form->keyValue('message', __('Message'))->rules('required');
        //dd($form->model()->name);
        $id = request()->route()->parameter('home_page');
        $model = $form->model()->find($id);
        if ($model->name == 'Working Hours') {
            //time range
            $form->embeds('value', __('admin.custom.homepage.value.title'), function ($form) {
                $form->timeRange('start', 'end', __('admin.custom.homepage.value.date-range'))->help(__('admin.custom.homepage.value.date-range-help'))->rules('required');
                //$form->timeRange('zh', __('admin.custom.homepage.value.zh-CN'))->rules('required');
            });
            $form->saving(function ($form) {
                $form->value = array('start' => Carbon::parse($form->value['start'])->format('H:i'), 'end' => Carbon::parse($form->value['end'])->format('H:i'));
                //$form->value['start'] = Carbon::parse($form->value['start'])->format('H:i');
                //$form->value['end'] = Carbon::parse($form->value['end'])->format('H:i');
            });
        } else if ($model->name == 'Maintenance') {
            //switch
            $form->embeds('value', __('admin.custom.homepage.value.title'), function ($form) {
                $states = [
                    'on'  => ['value' => true, 'text' => 'enable', 'color' => 'success'],
                    'off' => ['value' => false, 'text' => 'disable', 'color' => 'danger'],
                ];

                $form->switch('boolean', __('Maintenance'))->states($states);
                /* $form->submitted(function ($form) {
                    $this->confirm('Are you sure to copy this row?');
                    //$form->value = array('start' => Carbon::parse($form->value['start'])->format('H:i'), 'end' => Carbon::parse($form->value['end'])->format('H:i'));
                    //$form->value['start'] = Carbon::parse($form->value['start'])->format('H:i');
                    //$form->value['end'] = Carbon::parse($form->value['end'])->format('H:i');
                }); */
                //$form->timeRange('start', 'end', __('admin.custom.homepage.value.date-range'))->rules('required');
                //$form->timeRange('zh', __('admin.custom.homepage.value.zh-CN'))->rules('required');
            });
        } else if (in_array($model->name, ['Remittance', 'Arrival'])) {
            //zh en
            $form->embeds('value', __('admin.custom.homepage.value.title'), function ($form) {
                $form->text('en', __('admin.custom.homepage.value.en'))->rules('required');
                $form->text('zh', __('admin.custom.homepage.value.zh-CN'))->rules('required');
            });
        } else if (in_array($model->name, ['Tel'])) {
            //zh en
            $form->embeds('value', __('admin.custom.homepage.value.title'), function ($form) {
                $form->mobile('value', __('admin.custom.homepage.value.tel'))->rules('required');
            });

            $form->saving(function ($form) {
                $form->value = array('value' => preg_replace("/[^0-9.]/", "", $form->value['value']));
            });
        } else if (in_array($model->name, ['Transaction Complete', 'Money Saved', 'Hours Time Saved'])) {
            //number
            $form->embeds('value', __('admin.custom.homepage.value.title'), function ($form) {
                $form->text('value', __('admin.custom.homepage.value.value'))->rules('required');
            });
            $form->saving(function ($form) {
                $form->value = array('value' => preg_replace("/[^0-9.]/", "", $form->value['value']));
                //$form->value['start'] = Carbon::parse($form->value['start'])->format('H:i');
                //$form->value['end'] = Carbon::parse($form->value['end'])->format('H:i');
            });
        } else {
            //string 
            $form->embeds('value', __('admin.custom.homepage.value.title'), function ($form) {
                $form->text('value', __('admin.custom.homepage.value.value'))->rules('required');
            });
        }


        return $form;
    }
}
