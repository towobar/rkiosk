<?php


use App\User;
use App\Article;
use App\Http\Controllers\OrderController;
use App\Util\HtmlMarkup;

use Illuminate\Http\Request;

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


//    Route::get('/order', function () {
//
//
//
//
//        $articles = Article::all();
//
//        return View::make('order')->with('articles',$articles);
//    });


    //  Ajax - Routes

    Route::get('/getRequest',function(Request $request) {

        if($request->ajax())
        {

            return 'AjaxRequest';
        }
        return 'NotAjaxRequest';

    });

    Route::post('/orderDetails',function(Request $request) {


        if($request->ajax())
        {

            //return var_dump(Response::json($request->all());

        //   echo  Response::json($request->input('orderNumber'));

            $orderNr =  $request->get('orderNumber');


          $orderPositions =  DB::table('orderpositions')

              ->join('articles', 'orderpositions.article_id', '=','articles.id' )

              ->select((DB::raw('orderpositions.order_nr,orderpositions.order_position,orderpositions.units,
                       articles.id, articles.name,articles.price,(orderpositions.units*articles.price) AS subtotal ')))

              ->where('orderpositions.order_nr','=',$orderNr)
              ->get();



          //  echo var_dump($orderPositions); exit;

           $orderPositionsHtml = HtmlMarkup::OrderPositions($orderPositions);

           return $orderPositionsHtml;
        }

        return 'NotAjaxPostRequest';

    });




    Route::get('/order','OrderController@index' );

    Route::post('/order','OrderController@order' );

    Route::get('/order/{group}','OrderController@sortiment' );






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

