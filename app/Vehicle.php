<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model {
  /**
   * Vehicle has many attributes.
   */
  public function attributes() {
    return $this->hasMany('App\VehicleAttribute');
  }

  /**
   * Has many relationship with Booking.
   */
  public function bookings() {
    return $this->belongsTo('App\Booking', 'vehicle_id', 'id');
  }
}
