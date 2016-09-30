<?php
/**
 * Created by PhpStorm.
 * User: tombar
 * Date: 23.04.2016
 * Time: 11:49
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use View;
use App\Article;

use DB;



class ArticleController extends Controller
{


    public function Index(Request $request,$group=0, $filename='fileName')
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


        // Initialisierung für die Bild-Anzeige des 1. Artikels
         // $article = $articles->first();

        foreach ($articles as $article)
        {
            $initArticleName  =  $article->name;
            $initArticleImage =  'images/article/' . $article->image;

            break;

        }



        // einzelWert (  Column ) abfragen mit value()
        $actSortiment =  DB::table('sortiments')->where('group','=',$group)->value('name_long');

        $sortiments = DB::table('sortiments')->orderBy('group','asc')->get();


        return View::make('/admin/articles')->with('articles',$articles)
            ->with('initArticleName',$initArticleName)
            ->with('initArticleImage',$initArticleImage)
            ->with('sortiments',$sortiments)
            ->with('actSortiment',$actSortiment)
            ->with('filename',$filename);



    }

    public function Refresh(Request $request)
    {


        $actSortiment = $request['actSortiment'];



        $group = DB::table('sortiments')
            ->where('name_long',$actSortiment)->value('group');


        flash()->info('Refreshing successful');


        // Zurück zum index mit Parameter
        return redirect()->action('ArticleController@index',[$group,'']);



    }

    public function Upload(Request $request)
    {
        $destinationPath = public_path('/images/article/');

        $image = $request->file('image');

        // Hidden-Input!
        $actSortiment = $request['actSortiment'];
        $group = 0;
        $orignImagename = '';
        if(isset($image))
        {
            $image->move($destinationPath, $image->getClientOriginalName());
            $orignImagename = $image->getClientOriginalName();

            // Aktuelle Gruppe aus $actSortiment bestimmen
            $group = DB::table('sortiments')
                ->where('name_long',$actSortiment)->value('group');

           // Message Class from  Laracats/Flash Packet !
            flash()->info('Upload successful');

        }
        else{

            flash()->error('Upload Error !');

        }



        // Achtung : named Route
      //  return redirect()->route('adminArticle', ['group'=>1.1,'filename' => $orignImagename]);

        // Zurück zum index mit Parameter
        return redirect()->action('ArticleController@index',['group'=> $group,'filename' => $orignImagename]);



    }

    public function AttachImage(Request $request)
    {

        $image = $request['adminArticleImageName'];
        $articleID = $request['adminArticleID'];
        // Hidden-Input!

        $group = 0;
        $actSortiment = $request['actSortiment'];

        if(($articleID === '' || $image == 'image'))
        {
            flash()->error('First Upload an Image and set the articleID (AID)');

        }
        else
        {
            DB::table('articles')
                ->where('id',$articleID)
                ->update(['image' => $image]);

            // Aktuelle Gruppe aus $actSortiment bestimmen
            $group = DB::table('sortiments')
                ->where('name_long',$actSortiment)->value('group');

//        $inputs = $request->all();
//
//        var_dump($inputs); exit;

            flash()->info('Attach Image:' . $image .  ' successful');


        }


        // Zurück zum index mit Parameter
        return redirect()->action('ArticleController@index',['group'=>$group,'filename' => '']);



    }

    public function ArticleNew(Request $request)
    {

        $articleName = $request['newArticleName'];
        $articlePrice = $request['newArticlePrice'];

        $articleGroup = $request['newArticleGroup'];



        $article = new Article();

        $article->name = $articleName;
        $article->price = $articlePrice;
        $article->group = $articleGroup;
        $article->save();

//        $group = DB::table('sortiments')
//            ->where('name_long',$actSortiment)->value('group');


        //var_dump($group); exit;

        flash()->info('Article New : ' . $articleName . ' successful');


        // Zurück zum index mit Parameter
        return redirect()->action('ArticleController@index',['group'=> $articleGroup,'filename' => '']);

        // return redirect()->route('adminArticle', ['group'=> $articleGroup,'filename' => '']);


    }

    public function UpdateDelete(Request $request)
    {
        // Alle Form InputElemente in einem assoziativen Array
        $inputs = $request->all();


        $nameLong = $inputs['actSortiment'];

        // einzelWert (  Column ) abfragen mit value()
        $group =  DB::table('sortiments')->where('name_long','=',$nameLong)->value('group');


        if($inputs['submit'] == 'DELETE')
        {

            $this->Delete($inputs);

            flash()->info('Deleting Articles: successful');

        }
        else{
            $this->Update($inputs);

            flash()->info('Updating Articles: successful');
        }


        // Zurück zum index mit Parameter
        return redirect()->action('ArticleController@index',['group'=>$group,'filename' => '']);


    }

    public function Delete($inputs)
    {

         //var_dump($inputs); exit;

        // Array mit den ArtikelIds die gelöscht werden sollen
        $articleIDs = array();

        //Loop über das assoziative Array mit allen Inputs aus der AdminArticleForm-Liste
        foreach ($inputs as $key => $value) {


            $pos = strpos($key, 'check_');
            // Nur ausgewählte Artikel löschen
            if ($pos !== false && $value == 'on') {

                // Die ArtikelID in ein Array extrahieren : id[1] = ArtikelID
                $id = explode('check_',$key );

                array_push($articleIDs,$id[1]);
            }


        }


        // Die ausgewählen Artikel löschen
        $entries = count($articleIDs);

        for($i=0;$i<$entries;$i++)
        {

            DB::table('articles')->where('id',$articleIDs[$i])->delete();
        }


    }

    private function Update($inputs)
    {

   // Wird zum 2 Dimensionalen Array : 1. Dimension jeder Artikel : 2. Dimension [id,group,name,price,descrip,check]
        $article = array();

        $i=0;// Zähler 1. Dimension Artikel
        $j=0; // Zähler 2. Dimension [price,units,articleNr]

        // Zähler des aktuellen InputsElement
        $input = 1;

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

                if($input == 4) // price
                {

                    $article[$i][$j]= $value;
                    $j++;

                }

                if($input == 5) // descrip
                {

                    $article[$i][$j]= $value;
                    $j++;

                }


                if($input == 6) // check
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


        //var_dump($article); exit;

        $articleNumber = count($article);

        for($i=0;$i<$articleNumber;$i++){

            // Der Artikel ist nicht ausgewählt checked=off
            if($article[$i][5]=== 'off' ){
                continue;
            }

            DB::table('articles')
                ->where('id', $article[$i][0])
                ->update(['name' => $article[$i][2],'group' => $article[$i][1],'description' => $article[$i][4],'price' => $article[$i][3]]);

        }


    }


}