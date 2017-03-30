<?php
/**
 * Created by PhpStorm.
 * User: tombar
 * Date: 06.05.2016
 * Time: 16:45
 */

namespace App\Util;


class HtmlMarkup {


    public static function ViewOrderPositions(array $orderPositions)
    {
        $tblString =  '';

        // Head der DatenTabelle : Achtung die formatierung erfolgt mit den  css-Klassen

        $tblString  .= "<div id='tableDetails'>";
        $tblString  .= "<div class='tblHead'style='width:inherit;padding:0;border: none' >";
        $tblString  .=    "<div  >Pos</div>
                           <div   style='width:120px;'>Artikel</div>
                           <div  style='width:70px;'>Preis</div>
                           <div  >Menge</div>
                           <div  style='width:70px'>Gesamt</div>";
       $tblString .= "</div>";


        $orderGesamtPreis = 0;

        foreach ($orderPositions as $position)
        {

            // DataRow der OrderTabelle
            $tblString .= "<div   class='tblContent' style='width:inherit;padding:0;border: none '>";
            $tblString .=   "<div>" . $position->order_position . "</div>" . "<div style='width:120px'>" . $position->name . "</div>" ;
            $tblString .=   "<div style='width:70px'>" . $position->price . "</div>" . "<div>" . $position->units . "</div>";
            $tblString .=   "<div style='width:70px'>" . $position->subtotal . "</div>";
            $tblString .=  "</div>";

            $orderGesamtPreis = $orderGesamtPreis + $position->subtotal;

        }

        // Gesamt Preis aller bestellten Artikel
        $tblString .= "<div   class='tblHead' style='width:inherit;padding:0;border: none; '>" . "\n";
        $tblString .= "<div style='width:90px;padding-bottom:0'>Order gesamt : </div><div>".$orderGesamtPreis . "</div> </div>";


        $tblString .= "</div>". "\n";

        return $tblString;
    }

    public static function ViewOrderedArticlesOfDay(array $articles)
    {

        $orderedArticles = '';

        $orderedArticles .= '<h4 style="text-align: center">Die Artikelliste eines Tages</h4>';

        $orderedArticles .= '<table style="font-size:small;font-weight: bolder ">';

        $orderedArticles .= '<tr style="font-weight: bolder"><td style="width:50px">Anzahl</td><td style="width:160px">Artikel</td><td>Id</td></tr>';

        foreach ($articles as $oA)
        {
            $orderedArticles .= '<tr>';

            $preIndent = '&nbsp;&nbsp;&nbsp;&nbsp;';

            if($oA->units > 9)
                $preIndent = '&nbsp;&nbsp;';

            if($oA->units > 99)
                $preIndent = '';

            $orderedArticles .= '<td>'. $preIndent . $oA->units . '</td>';
            $orderedArticles .= '<td>'. $oA->name . '</td>';
            $orderedArticles .= '<td>'.  $oA->article_id . '</td>';
            $orderedArticles .= '</tr>';


        }

        $orderedArticles .= '</table>';
        return $orderedArticles;





    }
    
    public static function  GetGermanDateAndTime()
    {

        $tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");


        // Assoziatives Array da Januar = 1, nicht 0 ist !
        $monate = array(1=>"Januar",
            2=>"Februar",
            3=>"M&auml;rz",
            4=>"April",
            5=>"Mai",
            6=>"Juni",
            7=>"Juli",
            8=>"August",
            9=>"September",
            10=>"Oktober",
            11=>"November",
            12=>"Dezember");

        date_default_timezone_set('Europe/Berlin');


        $dateString = $tage[date('w')] . ', ';
        $dateString .= date('j') . ' ';
        $dateString .= $monate[date('n')] . ' ';
        $dateString .= date('Y') . ' | ';

        $dateString .= date('H:i') . ' Uhr';

        return $dateString;
    }

}