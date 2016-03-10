<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IceInIceOut extends Model {

  protected $table = 'sunsetlake_iceiniceout';

  protected $fillable = array('season', 'icein', 'iceout', 'duration');

}
