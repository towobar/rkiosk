<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use View;
use App\Article;
use App\Util\HtmlMarkup;
use DB;



class AdminInStockController extends Controller
{


    public function Index(Request $request,$group=0)
    {


       // echo $group; exit;


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


     



        // einzelWert (  Column ) abfragen mit value()
        $actSortiment =  DB::table('sortiments')->where('group','=',$group)->value('name_long');

        $sortiments = DB::table('sortiments')->orderBy('group','asc')->get();


        return View::make('/admin/instock')->with('articles',$articles)
            
            ->with('sortiments',$sortiments)
            ->with('actSortiment',$actSortiment);
           



    }
    
    
    
    public function Update(Request $request)
    {
        
        // Alle Form InputElemente in einem assoziativen Array
        $inputs = $request->all();


        $nameLong = $inputs['actSortiment'];

        // einzelWert (  Column ) abfragen mit value()
        $group =  DB::table('sortiments')->where('name_long','=',$nameLong)->value('group');

        
         $this->UpdateInStock($inputs);
         
         

        flash()->info('Updating Articles InStock: successful');
        


        // Zurück zum index mit Parameter
        return redirect()->action('AdminInStockController@index',['group'=>$group]);
         
        
        
    }
    
     private function UpdateInStock($inputs)
    {

        // Wird zum 2 Dimensionalen Array : 1. Dimension jeder Artikel : 2. Dimension [id,group,name,instock,check]
        $article = array();

        $i=0;// Zähler 1. Dimension Artikel
        $j=0; // Zähler 2. Dimension [id,group,name,instock,check]

        // Zähler des aktuellen InputsElement
        $input = 1;

        //var_dump($inputs); exit;
        
        
        
        //Loop über das assoziative Array mit allen Inputs aus der AdminArticleForm-Liste
        foreach ($inputs as $key => $value) {

            // Erstes Element ist der Token wird übersprungen
            if ($key != '_token' && $key != 'submit' && $key != 'actSortiment') {

                if($input == 1) // id
                {

                    $article[$i][$j]= $value;
                    $j++;

                }

                if($input == 2) // group
                {

                    $article[$i][$j]= $value;
                    $j++;

                }

                if($input == 3) // name
                {

                    $article[$i][$j]= $value;
                    $j++;

                }

                if($input == 4) // instock
                {

                    $article[$i][$j]= $value;
                    $j++;

                }

        


                if($input == 5) // check
                {
                    $article[$i][$j]= $value;

                    $i++; // nächster Artikel
                    $j=0; // zurücksetzen der ". Dimension
                    $input=1; // zurücksetzen des  Inputs

                    continue; // Alle inputs sind abgearbeitet neuer Artikel aus $inputs
                }

                $input++; // nächstes inputElement

            }


        }


       // var_dump($article); exit;

        $articleNumber = count($article);

        for($i=0;$i<$articleNumber;$i++){

            // Der Artikel ist nicht ausgewählt checked=off
            if($article[$i][4]=== 'off' ){
                continue;
            }

            DB::table('articles')
                ->where('id', $article[$i][0])
                ->update(['instock' => $article[$i][3]]);

        }


        
        // Aktualisieren des InstockDates der Gruppe 1.1 ( Brötchen )
       
        
        $instockdate = HtmlMarkup::GetGermanDateAndTime();
        
        DB::table('instockdates')
                ->where('group', 1.1)
                ->update(['instockdate' => $instockdate ]);
        
        
    }


    
}