<?php


use App\User;
use App\Article;
use App\Order;
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


            $orderPositionsHtml = HtmlMarkup::ViewOrderPositions($orderPositions);


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

    /**
     *  Alle Kunden Orders
     *
     *
     */
    Route::get('/admin/orders', function () {

       // $orders = Order::all();

        $orders =  DB::table('orders')

            ->join('users', 'orders.customer_id', '=','users.id' )

            ->select((DB::raw('orders.id,orders.order_date,users.name' )))

            ->get();

        return View::make('/admin/orders')->with('orders',$orders);

    });

    /**
     * Alle Kunden-Orders eines Tages,
     * der mit dem datepicker ausgewählt wird
     *
     */

    Route::post('/admin/ordersDay', function (Request $request) {


      $date = $request['datepickerAdmin1'];

        $orders =  DB::table('orders')

            ->join('users', 'orders.customer_id', '=','users.id' )

            ->select((DB::raw('orders.id,orders.order_date,users.name' )))

            ->where('order_date','=',$date)

            ->get();

        return View::make('/admin/orders')->with('orders',$orders);



    });

    /**
     *   Alle bestellten Artikel eines bestimmten Tages,
     *   der mit dem datepicker ausgewählt wird
     *
     */
    Route::post('/admin/ordersArticle', function (Request $request) {


        $date = $request['datepickerAdmin2'];


        $orderedArticles =  DB::table('orders')

            ->join('orderpositions','orders.id','=','orderpositions.order_nr')

            ->join('articles', 'orderpositions.article_id', '=','articles.id' )

            ->select((DB::raw('orderpositions.article_id,sum(orderpositions.units)as units,articles.name')))

            ->groupBy('articles.name')

            ->orderBy('articles.id','asc')

            ->where('orders.order_date','=',$date)

            ->get();



     //   echo var_dump($orderedArticles); exit;

        $htmlMarkup = HtmlMarkup::ViewOrderedArticlesOfDay($orderedArticles);


        // Message Class from  Laracats/Flash Packet !
        flash()->overlay($htmlMarkup,'Admin-Orders');

        return redirect('/admin/orders');



    });




    Route::get('/admin/news', function () {
        return view('/admin/news');
    });

});

