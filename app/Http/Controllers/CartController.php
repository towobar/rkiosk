<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Gloudemans\Shoppingcart\Facades\Cart;
use Validator;

use View;
use App\Article;
use App\Order;
use App\Orderposition;
use App\Sortiment;
use DB;
use Auth;
use Mail;



class CartController extends Controller
{


//    public function Index(Request $request)
//    {
//
//        $articles = Article::all();
//
//        $sortiments = DB::table('sortiments')->orderBy('group','asc')->get();
//
//        $actSortiment = 'GESAMT';
//
//        $customer = 'NICHT ANGEMELDET !';
//
//
//
//        if (!Auth::guest()) {
//
//            $customer = Auth::user()->name;
//
//        }
//
//
//        return View::make('order')->with('articles', $articles)
//            ->with('sortiments',$sortiments)
//            ->with('actSortiment',$actSortiment)
//            ->with('customer',$customer);
//
//    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart');
    }



    /**
     * Speicher ein Artikel aus der Article-Page in die Cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeArticle(Request $request)
    {

        // Validation on max quantity
        $validator = Validator::make($request->all(), [
            'units' => 'required|numeric|between:1,99'
        ]);

        if ($validator->fails()) {

            // Message Class from  Laracats/Flash Packet !
            flash()->error('Bitte geben sie eine Artikel-Anzahl ein.(1-99');

            // Zurück zum index mit Parameter
           //  return redirect()->action('ProductController@index',[$articleId]);
            // Geht schneller ohne Datenbankabfrage !
            return redirect()->back();
        }


        Cart::instance('shopping')->add($request->id, $request->name, $request->units,$request->price )->associate('Article');



        // Message Class from  Laracats/Flash Packet !
        flash()->success('Item : ' .  $request->name . ' wurde Ihrem Warenkorb hinzugefügt.');

        // Zurück zum index OrderPage mit Gesamt-Sortiment
        return redirect()->action('OrderController@index');
    }



    /**
     * Speichert die ausgewählten Artikel in die ShoppingCart : alte Version ohne Product-Site !
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // Alle Form InputElemente in einem assoziativen Array
        $inputs = $request->all();


        //  var_dump($inputs); exit;

        // Wird zum 2 Dimensionalen Array : 1. Dimension jeder Artikel : 2. Dimension [price,units,articleNr]
        $article = array();



        $i=0;// Zähler 1. Dimension Artikel
        $j=0; // Zähler 2. Dimension [price,units,articleNr]

        // Zähler des aktuellen InputsElement
        $input = 1;

        //Loop über das assoziative Array mit allen Inputs aus der OrderForm-Liste
        foreach ($inputs as $key => $value) {

            // Erstes Element ist der Token wird übersprungen
            if ($key != '_token' ) {

                if($input == 1) // name
                {

                    $article[$i][$j]= $value;
                    $j++;

                }

                if($input == 2) // price
                {

                    $article[$i][$j]= $value;
                    $j++;

                }

                if($input == 3) // units
                {
                    $article[$i][$j] = $value; // units

                    $j++;


                }

                if($input == 4) // articleNr
                {
                    $article[$i][$j] = $value; // articleNr

                    $i++; // nächster Artikel
                    $j=0; // zurücksetzen der ". Dimension
                    $input=1; // zurücksetzen des  Inputs

                    continue; // Alle inputs sind abgearbeitet neues ListElement aus $request($order)
                }

                $input++; // nächstes inputElement

            }
        }

        // article[i][name,price,units,articlNr]
        $articleNumber = count($article);

        // die Artikel werden in die shoppingCart gespeichert

        for($i=0;$i<$articleNumber;$i++){

            // Die Artikel units sind leer artikel überspringen
            if($article[$i][2]=== '' ){
                continue;
            }

            Cart::instance('shopping')->add($article[$i][3], $article[$i][0], $article[$i][2], $article[$i][1] )->associate('Article');

        }


//        Cart::instance('shopping')->add('293ad', 'Product 1', 2, 9.50,['date' => 'Freitag'] )->associate('Article');


        // Message Class from  Laracats/Flash Packet !
        flash()->info('Item(s) :  Added to Cart');

        // Zurück zum index OrderPage mit Gesamt-Sortiment
        return redirect()->action('OrderController@index');

    }


    /**
     * Update the specified resource in storage. Arbeitet mit jquery function auf der cart.blade Page zusammen
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        if($request->ajax()) {

            // Validation on max quantity
            $validator = Validator::make($request->all(), [
                'quantity' => 'required|numeric|between:1,99'
            ]);

            if ($validator->fails()) {

                // Message Class from  Laracats/Flash Packet !
                flash()->error('Quantity muss zwischen 1 un 99 sein.');

                return response()->json(['error' => true]);

            }

            $rowID =  $request->get('rowId');
            $quantity =  $request->get('quantity');

            Cart::instance('shopping')->update($rowID, $quantity);


            $item = Cart::get($rowID);

            // Message Class from  Laracats/Flash Packet !
            flash()->success('Quantity : ' . $item->name . 'wurde erfolgreich aktualisiert auf : ' . $item->qty );



            return response()->json(['rowID'=> $rowID , 'quantity' => $quantity]);


        }

        return 'NoAjax';

    }




   public function checkOut(Request $request)
   {


       if (Auth::guest())
       {

           // Message Class from  Laracats/Flash Packet !
           flash()->error('Für den Chekout bitte erst Login ausführen');

           // Zurück zum index
           return redirect()->action('CartController@index');

       }


       if( Cart::instance('shopping')->count() == 0){

           // Message Class from  Laracats/Flash Packet !
           flash()->error('Der Warenkorb ist noch leer !');

           // Zurück zum index
           return redirect()->action('CartController@index');


       }



       if($request['datepicker']== ''){

           // Message Class from  Laracats/Flash Packet !
           flash()->error('Bitte Order Datum eingeben');

           // Zurück zum index
           return redirect()->action('CartController@index');


       }

       $orderDate = $request['datepicker'];



       // 1. Eine neue Kunden Order anlegen in  der Tabelle Orders

       $order = new Order;

       $order->customer_id = Auth::user()->id;

       $order->order_date = $orderDate;

       $order->order_status = 'NEW';

       $order->save();

       $cartItems =  Cart::instance('shopping')->content();


       $orderPosition = 1;

       foreach($cartItems as $item)
       {


           $orderposition = new Orderposition();

           $orderposition->order_nr = $order->id; // Von der Instanz $Order
           $orderposition->order_position = $orderPosition++;
           $orderposition->article_id = $item->id;
           $orderposition->units = $item->qty;
           $orderposition->price = floatval($item->price);

           $orderposition->save();


          // echo $item->name . ':'.  $item->qty .    '<br>';

       }


       // Gesamt Preis der Bestellung
       $total =  Cart::instance('shopping')->total();

       $customer = Auth::user()->name;

       Mail::send('auth.emails.orderConfirmation',['cartItems'=>$cartItems,'orderDate'=>$orderDate,'total'=>$total,'customer'=>$customer],function($message)
       {
           $email = Auth::user()->email;
           $message->to($email,'TOMBAR')->subject('Order-Bestätigung');

       });



       // Message Class from  Laracats/Flash Packet !
       flash()->success('Wir haben ihre Order erhalten, vielen Dank.' . '<br>'. 'Eine Bestätigungs-Email wurde versandt.');

       // Zurück zum index
       return redirect()->action('CartController@index');


   }



    public function emptyCart()
    {
        Cart::instance('shopping')->destroy();


        // Message Class from  Laracats/Flash Packet !
         flash()->info('Your Cart has been Deleted');

        // Zurück zum index OrderPage mit Gesamt-Sortiment
        return redirect()->action('OrderController@index');

    }

    public function remove($id)
    {

        Cart::instance('shopping')->remove($id);

        // Zurück zum index CartController cart anzeigen
        return redirect()->action('CartController@index');


    }

}
