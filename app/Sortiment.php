<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sortiment extends Model
{
    protected $fillable = [
         'group', 'name_long','name_short'
    ];
}
