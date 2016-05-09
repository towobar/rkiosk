<?php
/**
 * Created by PhpStorm.
 * User: tombar
 * Date: 06.05.2016
 * Time: 16:45
 */

namespace App\Util;


class HtmlMarkup {

    public static function OrderPositions(array $orderPositions)
    {
        $htmlMarkup = '';

        $resultTotal = 0;
//        foreach($orderPositions as $position)
//        {
//          $htmlMarkup .=  $position->order_position . ' | ' . $position->name . ' | ' .
//                          $position->price . ' | ' . $position->units . ' | ' .
//                          $position->subtotal . ' | ' .     ($resultTotal += $position->subtotal ). '<br>';
//
//
//
//
//        }



       // return $htmlMarkup;






        $htmlMarkup .= '<table class="table">
                          <thead>
                            <tr>
                            <th>Pos</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Units</th>
                            <th>SubTotal</th>
                            <th>Total</th>
                            </tr>
                          </thead>
                          <tbody id="orderPos-list" name="orderPos-list">';


        foreach($orderPositions as $position) {

                $htmlMarkup .= '<tr>';

                    $htmlMarkup .= '<td>' . $position->order_position  . '</td>';
                    $htmlMarkup .= '<td>' . $position->name  . '</td>';
                    $htmlMarkup .= '<td>' . $position->price  . '</td>';
                    $htmlMarkup .= '<td>' . $position->units  . '</td>';
                    $htmlMarkup .= '<td>' . $position->subtotal  . '</td>';
                    $htmlMarkup .= '<td>' . ($resultTotal += $position->subtotal )  . '</td>';

                $htmlMarkup .= '</tr>';
        }

        $htmlMarkup .=  '</tbody>';
        $htmlMarkup .=  '</table>';

         return $htmlMarkup;
  }


}