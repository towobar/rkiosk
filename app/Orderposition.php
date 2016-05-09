<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderposition extends Model
{
   public $primaryKey = 'order_nr';

    protected $fillable = [
        'order_nr', 'order_position','article_id', 'units','price'
    ];
}
