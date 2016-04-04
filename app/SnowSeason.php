<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SnowSeason extends Model
{
  protected $table = 'snow_seasons';

  protected $fillable = array('year', 'month', 'total_sf', 'grts_sf', 'grts_sd');
}
