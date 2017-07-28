<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleAttribute extends Model {
  /**
   * Vehicle attributes belong to a vehicle.
   */
  public function vehicle() {
    return $this->belongsTo('App\Vehicle');
  }
}
