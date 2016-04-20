<?php


use App\User;


/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => 'web'], function () {


    // from artisan generated authorisation ( php artisan genrate: auth )

    Route::auth();


    Route::get('/', function () {
        return view('welcome');
    });


    Route::get('/news', function () {

        $users = User::all();

        return View::make('news')->with('users',$users);

        // return view('about');
    });


    Route::get('/order', function () {
        return view('order');
    });


//    Admin-Tools Rootes

    Route::get('/admin/customers', function () {
        return view('/admin/customers');
    });

    Route::get('/admin/articles', function () {
        return view('/admin/articles');
    });

    Route::get('/admin/instock', function () {
        return view('/admin/instock');
    });

    Route::get('/admin/sortiment', function () {
        return view('/admin/sortiment');
    });

    Route::get('/admin/orders', function () {
        return view('/admin/orders');
    });

    Route::get('/admin/news', function () {
        return view('/admin/news');
    });

});

