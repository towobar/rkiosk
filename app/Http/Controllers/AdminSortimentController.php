<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use View;
use App\Article;
use App\Sortiment;
use App\Util\HtmlMarkup;
use DB;


/**
 * Description of AdminSortimentController
 *
 * @author tombar
 */
class AdminSortimentController extends Controller {
    
    
    
    public function Index(Request $request)
    {
        
        $sortiments = DB::table('sortiments')->orderBy('group','asc')->get();

        // var_dump($sortiments); exit;
        
        
        return View::make('/admin/adminSortiment')->with('sortiments',$sortiments);
    }
    
    public function NewSortiment(Request $request)
    {
        $inputs = $request->all();
        
        //echo $inputs['submit']; exit;
   
        if($inputs['check']  === 'on')
        {
        
            $sortimentNameLong = $inputs['newSortimentNameLong'];
            $sortimentNameShort = $inputs['newSortimentNameShort'];
            $sortimentGroup = $inputs['newSortimentGroup'];



            $sortiment = new Sortiment();

            $sortiment->name_long = $sortimentNameLong;
            $sortiment->name_short = $sortimentNameShort;
            $sortiment->group = $sortimentGroup;
            $sortiment->save();


            flash()->info('Sortiment New : ' . $sortimentNameLong . ' successful');
        }
        else
        {
            flash()->info('Sortiment New : bitte Sortiment auswählen ! (checkbox)' );
            
            
        }
        

        // Zurück zum index mit Parameter
        return redirect()->action('AdminSortimentController@index');
        
    }
    
    public function UpdateDelete(Request $request)
    {
        
       
        
         // Alle Form InputElemente in einem assoziativen Array
        $inputs = $request->all();
        
        //echo $inputs['submit']; exit;
        
        if($inputs['submit'] == 'DELETE')
        {

            $this->Delete($inputs);

            flash()->info('Deleting Sortiment: successful');

        }
        else{
            $this->Update($inputs);

            flash()->info('Updating Sortiment: successful');
        }


        // Zurück zum index 
        return redirect()->action('AdminSortimentController@index');

        
        
    }
    
    public function Delete($inputs)
    {

    
         //var_dump($inputs); exit;

        // Array mit den ArtikelIds die gelöscht werden sollen
        $sortimentIDs = array();

        //Loop über das assoziative Array mit allen Inputs aus der AdminSortimentForm-Liste
        foreach ($inputs as $key => $value) {


            $pos = strpos($key, 'check_');
            // Nur ausgewähltes Sortiment löschen
            if ($pos !== false && $value == 'on') {

                // Die SortimentID in ein Array extrahieren : id[1] = SortimentID
                $id = explode('check_',$key );

                array_push($sortimentIDs,$id[1]);
            }


        }


        // Die ausgewählen Artikel löschen
        $entries = count($sortimentIDs);

        for($i=0;$i<$entries;$i++)
        {

            DB::table('sortiments')->where('id',$sortimentIDs[$i])->delete();
        }


    }
    
    
    private function Update($inputs)
    {

      
        
   // Wird zum 2 Dimensionalen Array : 1. Dimension jedes Sortiment : 2. Dimension [id,group,name_long,name_short,check]
        $sortiment = array();

        $i=0;// Zähler 1. Dimension Sortiment
        $j=0; // Zähler 2. Dimension [id,group,name_long,name_short,check]

        // Zähler des aktuellen InputsElement
        $input = 1;

        //Loop über das assoziative Array mit allen Inputs aus der SortimentsArticleForm-Liste
        foreach ($inputs as $key => $value) {

            // Erstes Element ist der Token wird übersprungen
            if ($key != '_token' && $key != 'submit' ) {

                if($input == 1) // id
                {

                    $sortiment[$i][$j]= $value;
                    $j++;

                }

                if($input == 2) // group
                {

                    $sortiment[$i][$j]= $value;
                    $j++;

                }

                if($input == 3) // name_long
                {

                    $sortiment[$i][$j]= $value;
                    $j++;

                }

                if($input == 4) // name_short
                {

                    $sortiment[$i][$j]= $value;
                    $j++;

                }

            
                if($input == 5) // check
                {
                    $sortiment[$i][$j]= $value;

                    $i++; // nächstes Sortiment
                    $j=0; // zurücksetzen der ". Dimension
                    $input=1; // zurücksetzen des  Inputs

                    continue; // Alle inputs sind abgearbeitet neues Sortiment aus $inputs
                }

                $input++; // nächstes inputElement

            }


        }


        //var_dump($article); exit;

        $sortimentNumber = count($sortiment);

        for($i=0;$i<$sortimentNumber;$i++){

            // Das Sortiment ist nicht ausgewählt checked=off
            if($sortiment[$i][4]=== 'off' ){
                continue;
            }

            DB::table('sortiments')
                ->where('id', $sortiment[$i][0])
                ->update(['name_long' => $sortiment[$i][2],'group' => $sortiment[$i][1],'name_short' => $sortiment[$i][3] ]);

        }


    }
}
