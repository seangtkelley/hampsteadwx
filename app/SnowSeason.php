<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SnowSeason extends Model
{
  protected $table = 'snowseason';

  protected $fillable = array('winter', 'oct', 'nov', 'dec', 'jan', 'feb', 'mar', 'apr', 'may', 'total');
}
