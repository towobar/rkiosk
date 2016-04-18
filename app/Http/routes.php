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

//Route::get('/', function () {
//    return view('welcome');
//});


//Route::get('/auth/login', function () {
//
//    return view('/auth/login');
//
//});

//Route::post('auth/login', function () {
//
//    return view('/auth/login');
//
//});
//
//Route::get('auth/register', function () {
//
//    return view('/auth/register');
//
//});




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

//Route::group(['middleware' => ['web']], function () {
//    //
//});

Route::group(['middleware' => 'web'], function () {



    Route::auth();

//    Route::get('/', function () {
//
//        Route::get('/', 'HomeController@index');
//
//        Route::get('/about', function () {
//
//            $users = User::all();
//
//            return View::make('about')->with('users',$users);
//
//            // return view('about');
//        });
//
//        Route::get('/contact', function () {
//            return view('contact');
//        });
//
//
//    })->middleware('guest');


    //Route::get('/', 'HomeController@index');

    Route::get('/', function () {
        return view('welcome');
    });


    Route::get('/about', function () {

        $users = User::all();

        return View::make('about')->with('users',$users);

        // return view('about');
    });

    Route::get('/projects', function () {
        return view('projects');
    });



    Route::get('/contact', function () {
        return view('contact');
    });


});

//Route::get('/', function () {
//    return view('welcome');
//});