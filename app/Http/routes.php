<?php


use App\User;
use App\Article;
use App\Sortiment;
use App\Order;
use App\Http\Controllers\OrderController;
use App\Util\HtmlMarkup;

use App\Message;

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

   
    // Vorrat an Brötchen zu einer bestimmten Uhrzeit
    Route::get('/customerInStock', function () {
       
        //$date = HtmlMarkup::GetGermanDateAndTime();
        //
    
        
        // Nur Brötchen werden angezeigt
        $group = 1.1;

        // einzelWert (  Column ) abfragen mit value() das Datum des instock-updates
        $date =  DB::table('instockdates')->where('group','=',$group)->value('instockdate');
        
        
        
        $articles = DB::table('articles')->where('group','=',$group)->get();
        
       // var_dump($articles);exit;
        return view('customerInStock')->with('articles', $articles)
                                      ->with('date', $date);
    });
   
    
    
    
    
    
    Route::get('/news', function () {

        $messages = Message::all();

        return View::make('news')->with('messages',$messages);

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

//    Route::post('/cartQuantity',function(Request $request) {
//
//
//
//
//        if($request->ajax())
//        {
//
//            return 'AjaxRequest';
//        }
//        return 'NotAjaxRequest';
//
//    });


// Customers Order Roots

    Route::get('/order','OrderController@index' );

    // Wird nicht mehr benötigt : da  neu Implemntierung mit Shopping-Cart
    Route::post('/order','OrderController@order' );

    Route::get('/order/{group}','OrderController@sortiment' );


// Article-Page : nur 1 Artikel ( Product wird in der View article.blade angezeigt
   Route::get('/article/{id}','ProductController@index') ;


// Cart Roots
    Route::post('/cartQuantity', 'CartController@update');

    // wird nicht mehr benötigt
    Route::resource('/cart/store', 'CartController@store');

    Route::post('/storeArticle', 'CartController@storeArticle');

    Route::post('/cartCheckout','CartController@checkOut' );

    Route::get('/cart','CartController@index' );

    Route::get('/cartRemove/{id}','CartController@remove' );

    Route::post('/emptyCart', 'CartController@emptyCart');

});


// Diese Roots sind nur für Admin erreichbar ! ansonsten Umleitung zur WelcomPage
// Admin-class ist im Http/Middleware Ordner

Route::group(['middleware' => 'admin'], function () {

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

    Route::post('/admin/ordersDeleteUpdate','AdminOrderController@DeleteUpdate');



    
    /**
     * Admin Customers Page
     */

     Route::get('/admin/customers','AdminCustomerController@index' );
     Route::post('/admin/customers/updateDelete','AdminCustomerController@UpdateDelete' );
     Route::post('/admin/customer/new','AdminCustomerController@NewCustomer' );
     
    
    /**
     * Admin InStock aktuelle Eingabe Anzahl von Brötchen
     * 
     */
     
     Route::get('/admin/instock/{group?}',[ 'as' => 'adInStock', 'uses' => 'AdminInStockController@index'] );
    
     Route::post('/admin/instock/update','AdminInStockController@Update' );
     
     // Route::post('/admin/instock/new','AdminInStockController@New' );
     
     
     
     
    /**
     * Admin Sortiment Eingabe
     */
     
      Route::get('/admin/sortiment','AdminSortimentController@index' );
      Route::post('/admin/sortiment/new','AdminSortimentController@NewSortiment' );
      Route::post('/admin/sortiment/updateDelete','AdminSortimentController@UpdateDelete' );
     
     

    /**
     *  Alle News (Messages)
     *
     *
     */
    Route::get('/admin/news','AdminNewsController@index');

    /**
     *  Neue News (Messages)
     *
     *
     */
    Route::post('/admin/news/newMessage','AdminNewsController@NewMessage');

    /**
     *  Delete News (Messages)
     *
     *
     */
    Route::post('/admin/news/deleteMessages','AdminNewsController@Delete');

    /**
     *  Send Newsletter (Messages) TestEmail + Email all Customers
     *
     *
     */
    Route::post('/admin/news/sendNewsletter','AdminNewsController@SendNewsletter');

});
