<?php
/**
 * Created by PhpStorm.
 * User: tombar
 * Date: 23.04.2016
 * Time: 11:49
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Util\HtmlMarkup;
use Illuminate\Http\Request;
use View;
use DB;



class AdminOrderController extends Controller
{
    /**
     * Alle Kunden Orders
     * @param Request $request
     * @return $this
     */
    public function Index(Request $request)
    {

        $orders =  DB::table('orders')

            ->join('users', 'orders.customer_id', '=','users.id' )

            ->select((DB::raw('orders.id,orders.order_date,users.name' )))

            ->get();

        return View::make('/admin/orders')->with('orders',$orders);

    }

    /**
     *
     * Die OrderDetails zu einer Kunden-Order: Bestellte Artikel
     * @param Request $request
     * @return string
     */
    public function OrderDetails(Request $request)
    {

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




    }


    /**
     * Alle Kunden Orders eines bestimmten Tages. Wird mit Datepicker ausgewählt
     *
     * @param Request $request
     * @return $this
     */
    public function OrdersOfDay(Request $request)
    {

        $date = $request['datepickerAdmin1'];

        $orders =  DB::table('orders')

            ->join('users', 'orders.customer_id', '=','users.id' )

            ->select((DB::raw('orders.id,orders.order_date,users.name' )))

            ->where('order_date','=',$date)

            ->get();

        return View::make('/admin/orders')->with('orders',$orders);




    }

    /**
     * Die gesamte Artikelliste eines Tages. Wird mit Datepicker ausgewählt
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function ArticlesOfDay(Request $request)
    {

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




    }

    public function Delete(Request $request)
    {

       // echo "Delete"; exit;

        // Alle Form InputElemente in einem assoziativen Array
        $inputs = $request->all();



        //var_dump($inputs); exit;

        // Array mit den ArtikelIds die gelöscht werden sollen
        $orderIDs = array();

        //Loop über das assoziative Array mit allen Inputs aus der AdminOrderForm-Liste
        foreach ($inputs as $key => $value) {


            $pos = strpos($key, 'check_');
            // Nur ausgewählte Artikel löschen
            if ($pos !== false && $value == 'on') {

                // Die ArtikelID in ein Array extrahieren : id[1] = ArtikelID
                $id = explode('check_',$key );

                array_push($orderIDs,$id[1]);
            }


        }


        // Die ausgewählen Artikel löschen
        $entries = count($orderIDs);

        for($i=0;$i<$entries;$i++)
        {

            DB::table('orders')->where('id',$orderIDs[$i])->delete();
        }

        flash()->info('Deleting Orders: successful');

        return redirect('/admin/orders');

    }
}