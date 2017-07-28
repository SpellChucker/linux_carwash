<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
  /**
   * Has one relationship with Vehicle.
   */
  public function vehicle() {
    return $this->hasOne('App\Vehicle', 'id', 'vehicle_id');
  }
}
