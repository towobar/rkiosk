<?php


use App\User;
use App\Article;
use App\Sortiment;
use App\Order;
use App\Http\Controllers\OrderController;
use App\Util\HtmlMarkup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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



    //  Ajax - Routes nur zum Beispiel !

    Route::get('/getRequest',function(Request $request) {

        if($request->ajax())
        {

            return 'AjaxRequest';
        }
        return 'NotAjaxRequest';

    });




// Customers Order Roots

    Route::get('/order','OrderController@index' );

    Route::post('/order','OrderController@order' );

    Route::get('/order/{group}','OrderController@sortiment' );



//    Admin-Tools Rootes

    // Admin-Article Rootes

    Route::get('/admin/articles/{group?}/{filename?}',[ 'as' => 'adArticles', 'uses' => 'ArticleController@index'] );
    Route::post('/admin/articles/upload','ArticleController@upload' );
    Route::post('/admin/articles/attachImage','ArticleController@AttachImage' );
    Route::post('/admin/articles/refresh','ArticleController@refresh' );
    Route::post('/admin/articles/new','ArticleController@ArticleNew' );
    Route::post('/admin/articles/updateDelete','ArticleController@UpdateDelete' );



      // Admin Orders Rootes

    /**
     *  Alle Kunden Orders
     *
     *
     */
    Route::get('/admin/orders','AdminOrderController@index');

    /**
     * Alle Kunden-Orders eines Tages,
     * der mit dem datepicker ausgewählt wird
     *
     */
    Route::post('/admin/ordersDay','AdminOrderController@OrdersOfDay');

    /**
     *   Alle bestellten Artikel eines bestimmten Tages,
     *   der mit dem datepicker ausgewählt wird
     *
     */
    Route::post('/admin/ordersArticle','AdminOrderController@ArticlesOfDay');

    /**
     * Die OrderDetails zu einer Kundenorder: Die ArtikelListe
     */
    Route::post('/admin/orderDetails','AdminOrderController@OrderDetails');

    Route::post('/admin/ordersDelete','AdminOrderController@Delete');

    Route::get('/admin/customers', function () {
        return view('/admin/customers');
    });

    Route::get('/admin/instock', function () {
        return view('/admin/instock');
    });


    Route::get('/admin/sortiment', function () {
        return view('/admin/sortiment');
    });


    Route::get('/admin/news', function () {
        return view('/admin/news');
    });

});

