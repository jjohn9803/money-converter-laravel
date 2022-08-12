<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/language/{locale}', function ($locale) {
        if (!in_array($locale, ['en', 'zh-CN'])) {
            abort(400);
        }
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    });

    $router->get('/', 'DashboardController@index')->name('home');
    $router->resource('/', DashboardController::class);
    //$router->get('/', 'HomeController@index')->name('home');
    $router->get('/get-recent', 'HomeController@getRecentRecord');
    $router->resource('users', UserController::class);
    $router->resource('banks', BankController::class);
    $router->resource('bank-accounts', BankAccountController::class);
    $router->resource('countries', CountryController::class);
    $router->resource('currencies', CurrencyController::class);
    $router->resource('fxes', FxController::class);
    $router->resource('transactions', TransactionController::class);
    $router->resource('notifications', NotificationController::class);
    $router->resource('reasons', ReasonController::class);
    $router->resource('home-pages', HomePageController::class);
    $router->resource('contacts', ContactController::class);
    $router->get('/getNotification', 'TransactionController@transactionNotification');
});
