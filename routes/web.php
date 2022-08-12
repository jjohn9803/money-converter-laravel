<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FxController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}); */

/* Route::group(['middleware' => 'setLocale:zh'], function () {
    
    Route::get('/', [HomeController::class, 'index']);
}); */

Route::get('/language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'zh-CN'])) {
        abort(400);
    }

    Session::put('locale', $locale);
    return redirect()->back();
});

Route::group(['middleware' => 'setLocale'], function () {
    Route::get('email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
    Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

    Route::get('/', [HomeController::class, 'index']);
    Route::post('/validate-register', [HomeController::class, 'validateRegister']);
    Route::post('/register', [HomeController::class, 'register']);
    Route::post('/validate-login', [HomeController::class, 'validateLogin']);
    Route::post('/login', [HomeController::class, 'login']);
    Route::post('/email/exist', [HomeController::class, 'exist_email']);
    Route::get('/rt_fxes', [FxController::class, 'getRealtimeFxes']);
});

Route::group(['middleware' => ['auth', 'setLocale']], function () {
    Route::get('/logout', [LogoutController::class, 'perform']);

    Route::get('/get-notification', [HomeController::class, 'getNotification']);
    //Route::get('/get-notification/{id}', [HomeController::class, 'getNotificationById']);
    Route::get('/view-notification', [HomeController::class, 'viewNotification'])->name('view-notification');
    Route::put('/update-notification', [HomeController::class, 'updateNotification']);
    Route::put('/read-all-notification', [HomeController::class, 'readAllNotification']);

    Route::get('/view-transaction-history', [TransactionController::class, 'viewTransaction']);
    Route::get('/validate-before-update-transaction-history', [TransactionController::class, 'validateTransaction']);
    Route::get('/get-transaction-history', [TransactionController::class, 'getTransaction']);
    Route::get('/get-transaction-history-id', [TransactionController::class, 'getSingleTransaction']);
    Route::post('/update-transaction-history', [TransactionController::class, 'updateTransaction']);
    //Route::post('/upload-img', [TransactionController::class, 'saveImg']);
});

Route::group(['middleware' => ['verified', 'setLocale']], function () {
    Route::post('/validate-form', [HomeController::class, 'validateForm']);
    Route::post('/receipt-form', [HomeController::class, 'receipt']);
    //Route::get('/receipt-form', [HomeController::class, 'receipt']);
    //Route::get('/view-receipt', [HomeController::class, 'viewReceipt'])->name('view-receipt');
    Route::get('/view-receipt/{id}', [HomeController::class, 'viewReceipt'])->name('view-receipt');

    /* Route::get('/fx/{base_id}/{result_id}', [FxController::class, 'fx_rate']); */

    /* Auth::routes(); */
});


/* Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice'); */

/* Auth::routes(['verify' => true]); */



//Route::get('/qwer', [HomeController::class, 'index'])->middleware('verified');



Route::get('/fx', [FxController::class, 'fx_rate']);
Route::get('/getCurr', [CurrencyController::class, 'getCurrencyWithCountry']);
Route::get('/getAlpha2Code', [CountryController::class, 'getAlpha2Code']);


Route::get('/api', [CountryController::class, 'index']);

/* Route::get('/', function () {
    return view('homepage');
}); */

Route::get('/1', function () {
    return view('currencies');
});

Route::get('/2', function () {
    return view('lmao');
});

Route::get('/3', function () {
    return view('layouts/modal-transaction-history');
});
