<?php
/**
 * Created by PhpStorm.
 * User: tombar
 * Date: 23.04.2016
 * Time: 11:49
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Orderposition;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Mail;
use View;
use App\Article;
use App\Order;
use App\Sortiment;
use DB;
use Auth;
use Mail;


class OrderController extends Controller
{

    public function Index(Request $request)
    {

        $articles = Article::all();

        $sortiments = DB::table('sortiments')->orderBy('group','asc')->get();

        $actSortiment = 'GESAMT';

        $customer = 'NICHT ANGEMELDET !';



        if (!Auth::guest()) {

            $customer = Auth::user()->name;

        }


        return View::make('order')->with('articles', $articles)
                                  ->with('sortiments',$sortiments)
                                  ->with('actSortiment',$actSortiment)
                                  ->with('customer',$customer);

    }

    public function Sortiment(Request $request, $group)
    {

        // Alle Atikel
        if($group == 0)
        {
            $articles = Article::all();

        }
        else{ //  Nur Artikel einer Gruppe


            // es ist eine Sortiment-Untergruppe die einzeln angezeigt wird
            $x = $group;
            if($x = $x - floor($x)  != 0)
            {
                $articles = DB::table('articles')->where('group','=',$group)->get();

            }
            else // Es ist eine Hauptgruppe ein Bereich wird ausgegeben z.B. 1.0 Bereich 1.1 -1.9
            {

                $min = $group;
                $max = $group + 0.9;


                $articles = DB::table('articles')->whereBetween('group', [$min, $max])->get();

            }

        }


        $sortiments = DB::table('sortiments')->orderBy('group','asc')->get();

       // einzelWert (  Column ) abfragen mit value()
        $actSortiment =  DB::table('sortiments')->where('group','=',$group)->value('name_long');



        //Default nicht eingelogt
        $customer = 'NICHT ANGEMELDET !';

       //Eingeloggter Customer
        if (!Auth::guest()) {

            $customer = Auth::user()->name;

        }


        return View::make('order')->with('articles', $articles)
            ->with('sortiments',$sortiments)
            ->with('actSortiment',$actSortiment)
            ->with('customer',$customer);



    }


    /**
     * Wird nicht mehr benötigt, da die Order über den Warenkorb ( shopping-Cart ) beim checkout erfolgt
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function Order(Request $request)
    {

        // Alle Form InputElemente in einem assoziativen Array
        $inputs = $request->all();


        if($request['datepicker']== ''){

            // Message Class from  Laracats/Flash Packet !
            flash()->error('Bitte Order Datum eingeben');

            // Zurück zum index OrderPage mit Gesamt-Sortiment
            return redirect()->action('OrderController@index')->withInput($inputs);


        }

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
            if ($key != '_token' && $key != 'datepicker') {

                if($input == 1) // price
                {

                    $article[$i][$j]= $value;
                    $j++;

                }

                if($input == 2) // units
                {
                    $article[$i][$j]= $value; // units

                    $j++;

                    $articleNr = explode('units_', $key); // articleNr ist in name enthalten units_articleNr

                    $article[$i][$j]= $articleNr[1];


                    $i++; // nächster Artikel
                    $j=0; // zurücksetzen der ". Dimension
                    $input=1; // zurücksetzen des  Inputs

                    continue; // Alle inputs sind abgearbeitet neues ListElement aus $request($order)
                }

                $input++; // nächstes inputElement

            }
            else{

                if ( $key == 'datepicker')
                {

                    $orderDate = $value;
                }


            }

        }

      //  var_dump($article); echo '<br> ###### <br> OrderDate : ' .  $orderDate; exit;

        // 1. Eine neue Kunden Order anlegen in  der Tabelle Orders

        $order = new Order;

        $order->customer_id = Auth::user()->id;

        $order->order_date = $orderDate;

        $order->order_status = 'NEW';

        $order->save();

       // In der Instanz $order befindet sich nach save in die Datenbank die orderId ( autoincrement )

        // 2. Die Order Positionen anlegen in der Tabelle orderpositions

        // article[i][price,units,articlNr]
        $articleNumber = count($article);
        $orderPosition = 1;

        for($i=0;$i<$articleNumber;$i++){

            // Die Artikel units sind leer artikel überspringen
            if($article[$i][1]=== '' ){
                continue;
            }

            $orderposition = new Orderposition();

            $orderposition->order_nr = $order->id; // Von der Instanz $Order
            $orderposition->order_position = $orderPosition++;
            $orderposition->article_id = $article[$i][2];
            $orderposition->units = $article[$i][1];
            $orderposition->price = floatval($article[$i][0]);

            $orderposition->save();



        }


        // Erstellen der Artikelliste für die Bestätigungs-Email an den Kunden
        $orderedArticles =  DB::table('orderpositions')

            ->join('articles', 'orderpositions.article_id', '=','articles.id' )

            ->select((DB::raw('orderpositions.article_id,orderpositions.units,articles.name,articles.price')))

            ->orderBy('articles.name','asc')

            ->where('orderpositions.order_nr','=',$order->id)

            ->get();


     //var_dump($orderedArticles); exit;

        // Email verschicken an Kunde mit Orderübersicht

        // Gesamt Preis der Bestellung wird in der View berechnet.
        $total = '';

        $customer = Auth::user()->name;

        Mail::send('auth.emails.orderConfirmation',['orderedArticles'=>$orderedArticles,'orderDate'=>$orderDate,'total'=>$total,'customer'=>$customer],function($message)
        {
            $email = Auth::user()->email;
            $message->to($email,'TOMBAR')->subject('Order-Bestätigung');

        });


        // Message Class from  Laracats/Flash Packet !
        flash()->info('Order successful');

        // Zurück zum index OrderPage mit Gesamt-Sortiment
        return redirect()->action('OrderController@index');


    }
}