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
use App\User;
use DB;
use Hash;

/**
 * Description of AdminCustomerController
 *
 * @author tombar
 */
class AdminCustomerController extends Controller {
    
    public function Index(Request $request)
    {

        $customers = DB::table('users')->orderBy('name','asc')->get();

        // var_dump($sortiments); exit;


        return View::make('/admin/customers')->with('customers',$customers);
    }

    
    public function NewCustomer(Request $request)
    {
        $inputs = $request->all();
        
        //echo $inputs['submit']; exit;
   
        if($inputs['check']  === 'on')
        {
        
            $customerName = $inputs['customerName'];
            $customerAnrede = $inputs['customerAnrede'];
            $customerEmail = $inputs['customerEmail'];
            $customerPassword = $inputs['customerPassword'];
            $customerNewsletter = false;
          
            if($inputs['checknl'] === 'on')
            {
                $customerNewsletter = true;
            }



            $user = new User();

            $user->name =  $customerName;
            $user->title = $customerAnrede;
            $user->email = $customerEmail;
            $user->password = Hash::make($customerPassword);
            $user->newsletter = $customerNewsletter;
            $user->remember_token = str_random(60);  // Str::random(60);
            $user->save();


            flash()->info('Customer New : ' . $customerName . ' successful');
        }
        else
        {
            flash()->info('Customer New : bitte Customer auswählen ! (checkbox)' );
            
            
        }
        

        // Zurück zum index mit Parameter
        return redirect()->action('AdminCustomerController@index');
        
    } 
    
    
    public function UpdateDelete(Request $request)
    {
        
       
        
         // Alle Form InputElemente in einem assoziativen Array
        $inputs = $request->all();
        
        //echo $inputs['submit']; exit;
        
        if($inputs['submit'] == 'DELETE')
        {

            $this->Delete($inputs);

            flash()->info('Deleting Customer: successful');

        }
        else{
            $this->Update($inputs);

            flash()->info('Updating Customer: successful');
        }


        // Zurück zum index 
        return redirect()->action('AdminCustomerController@index');

        
        
    }
    
    public function Delete($inputs)
    {

    
         //var_dump($inputs); exit;

        // Array mit den ArtikelIds die gelöscht werden sollen
        $customerIDs = array();

        //Loop über das assoziative Array mit allen Inputs aus der AdminSortimentForm-Liste
        foreach ($inputs as $key => $value) {


            $pos = strpos($key, 'check_');
            // Nur ausgewähltes Sortiment löschen
            if ($pos !== false && $value == 'on') {

                // Die CustomerID in ein Array extrahieren : id[1] = SortimentID
                $id = explode('check_',$key );

                array_push($customerIDs,$id[1]);
            }


        }


        // Die ausgewählen Artikel löschen
        $entries = count($customerIDs);

        for($i=0;$i<$entries;$i++)
        {

            DB::table('users')->where('id',$customerIDs[$i])->delete();
        }


    }
    
    
    private function Update($inputs)
    {

      
        
   // Wird zum 2 Dimensionalen Array : 1. Dimension jedes Sortiment : 2. Dimension [id,name,anrede,email,checknl,check]
        $customers = array();

        $i=0;// Zähler 1. Dimension Sortiment
        $j=0; // Zähler 2. Dimension [id,name,anrede,email,checknl,check]

        // Zähler des aktuellen InputsElement
        $input = 1;

        //Loop über das assoziative Array mit allen Inputs aus der SortimentsArticleForm-Liste
        foreach ($inputs as $key => $value) {

            // Erstes Element ist der Token wird übersprungen
            if ($key != '_token' && $key != 'submit' ) {

                if($input == 1) // id
                {

                    $customers[$i][$j]= $value;
                    $j++;

                }

                if($input == 2) // name
                {

                    $customers[$i][$j]= $value;
                    $j++;

                }

                if($input == 3) // anrede
                {

                    $customers[$i][$j]= $value;
                    $j++;

                }

                if($input == 4) // email
                {

                    $customers[$i][$j]= $value;
                    $j++;

                }

                if($input == 5) // checknl newsletter
                {
                    //$customers[$i][$j]= $value;
                    
                    if($value  === 'on')
                    {
                        $customers[$i][$j] = true;
                    }
                    else
                    {
                        $customers[$i][$j] = false;
                        
                    }
                    
                    $j++;
                  
                }
                
                
                
            
                if($input == 6) // check  ist der customer ausgewählt
                {
                    $customers[$i][$j]= $value;

                    $i++; // nächstes Sortiment
                    $j=0; // zurücksetzen der ". Dimension
                    $input=1; // zurücksetzen des  Inputs

                    continue; // Alle inputs sind abgearbeitet neues Sortiment aus $inputs
                }

                $input++; // nächstes inputElement

            }


        }


        //var_dump($article); exit;

        $customerNumber = count($customers);

        for($i=0;$i<$customerNumber;$i++){

            // Der Customer ist nicht ausgewählt checked=off
            if($customers[$i][5]=== 'off' ){
                continue;
            }

            DB::table('users')
                ->where('id', $customers[$i][0])
                ->update(['name' => $customers[$i][1],'title' => $customers[$i][2],'email' => $customers[$i][3],'newsletter' => $customers[$i][4] ]);

        }


    }

}
