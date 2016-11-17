<?php
/**
 * Created by PhpStorm.
 * User: tombar
 * Date: 10.11.2016
 * Time: 10:37
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use View;
use App\Message;
use App\User;
use DB;
use Mail;


class AdminNewsController extends Controller
{

    public function Index(Request $request)
    {
        // Achtung model Messages anstatt News, da News Schlüsselwort von php
        $news = Message::all();


        return View::make('/admin/news')->with('news', $news);


    }

    public function NewMessage(Request $request)
    {

        $head = $request['newsHead'];
        $content = $request['newsContent'];

        $date = $request['newsDate'];



        $message = new Message();

        $message->head = $head;
        $message->content = $content;
        $message->date = $date;
        $message->save();

//        $group = DB::table('sortiments')
//            ->where('name_long',$actSortiment)->value('group');


        //var_dump($group); exit;

        flash()->info('Add News : ' . $message->head . ' successful');


        // Zurück zum index mit Parameter
        return redirect()->action('AdminNewsController@index');

        // return redirect()->route('adminArticle', ['group'=> $articleGroup,'filename' => '']);


    }


    public function Delete(Request $request)
    {
        // Alle Form InputElemente in einem assoziativen Array
        $inputs = $request->all();

        //var_dump($inputs); exit;

        // Array mit den MessageIds die gelöscht werden sollen
        $messageIDs = array();

        //Loop über das assoziative Array mit allen Inputs aus der AdminArticleForm-Liste
        foreach ($inputs as $key => $value) {


            $pos = strpos($key, 'check_');
            // Nur ausgewählte Artikel löschen
            if ($pos !== false && $value == 'on') {

                // Die ArtikelID in ein Array extrahieren : id[1] = ArtikelID
                $id = explode('check_',$key );

                array_push($messageIDs,$id[1]);
            }


        }


        // Die ausgewählen Artikel löschen
        $entries = count($messageIDs);

        for($i=0;$i<$entries;$i++)
        {

            DB::table('messages')->where('id',$messageIDs[$i])->delete();
        }

        flash()->info( $entries .  ' News Deleted');


        // Zurück zum index mit Parameter
        return redirect()->action('AdminNewsController@index');



    }



    public function SendNewsletter(Request $request)
    {

        // Alle Form InputElemente in einem assoziativen Array
        $inputs = $request->all();


        if($inputs['submit'] == 'TEST')
        {

            $this->TestEmail($inputs);

            flash()->info('Sending Testemail: successful');

        }
        else{
            $this->NewsletterToCustomers();

            flash()->info('Sending Newsletter to Customers successful');
        }



        // Zurück zum index
        return redirect()->action('AdminNewsController@index');




    }

    /**
     *
     * Sendet eine Test-Newsletter an die im input spezifizierte Adresse
     * @param $inputs
     *
     */
    private function TestEmail($inputs)
    {

       $emailAdress = $inputs['emailAdress'];


       // Get last entry ( newsletter ) in Table messages

       $latestNewsletter =  DB::table('messages')->orderBy('ID', 'desc')->first();


        Mail::send('auth.emails.newsletter',['head'=>$latestNewsletter->head,'content'=>$latestNewsletter->content,'date'=>$latestNewsletter->date,'customer'=>'Schulz'],function($message) use($emailAdress)
        {
            $email = $emailAdress;
            $message->to($email,'TOMBAR')->subject('Test Newsletter');

        });


    }

    /**
     * Sendet den letzten Newsletter an alle Kunden
     *
     */
    private function NewsletterToCustomers()
    {

        $users = User::all();

        // Get last entry ( newsletter ) in Table messages

        $latestNewsletter =  DB::table('messages')->orderBy('ID', 'desc')->first();


        foreach ($users as $user) {

            if($user->name == 'ADMIN')
                continue;


            Mail::send('auth.emails.newsletter',['head'=>$latestNewsletter->head,'content'=>$latestNewsletter->content,'date'=>$latestNewsletter->date,'customer'=>$user->name],function($message) use($user)
            {
                $email = $user->email;
                $message->to($email,$user->email)->subject('WebKioskHaselhorst Newsletter');

            });




        }



    }

}
