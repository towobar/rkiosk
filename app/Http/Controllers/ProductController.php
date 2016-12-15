<?php
/**
 * Created by PhpStorm.
 * User: tombar
 * Date: 14.12.2016
 * Time: 15:27
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


class ProductController extends Controller
{

    public function index($id)
    {

        // Achtung return : array mit Article-Objekt $article[0] enthält den Artikel!
        $article =  DB::table('articles')


            ->where('id','=',$id)

            ->get();


        return View::make('/article')->with('article',$article[0]);
    }





}