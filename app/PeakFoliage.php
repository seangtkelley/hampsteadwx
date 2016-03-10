<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeakFoliage extends Model {

  protected $table = 'peakfoliage';

  protected $fillable = array('year', 'date');

}
