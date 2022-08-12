<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use Encore\Admin\Facades\Admin;

Admin::js('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.min.js');
//Admin::js('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.esm.js');
//Admin::js('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.esm.min.js');
Admin::js('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.js');
//Admin::js('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/helpers.esm.js');
//Admin::js('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/helpers.esm.min.js');
Admin::style('th:not(:last-child),td:not(:last-child) {text-align: center;}');
/* Admin::script('console.log("hello world");'); */
Encore\Admin\Form::forget(['map', 'editor']);
\Encore\Admin\Facades\Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar){
    $navbar->right(new \App\Admin\Extensions\Nav\Links());
    $navbar->right(new \App\Admin\Extensions\Lang\Links());
});