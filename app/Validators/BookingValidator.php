<?php

namespace App\Validators;

class BookingValidator {

  public function validate($attribute, $value, $parameters, $validator) {
    $booking_data = request()->all();

    $total_price = $booking_data['booking']['total_cost'];

    $calculated_price = 0;

    if ($booking_data['vehicle']['type'] == 'truck') {
      $calculated_price += 10;
    } else if ($booking_data['vehicle']['type'] == 'car') {
      $calculated_price += 5;
    }

    // Vehicles may or may not have attributes.
    if (!empty($booking_data['vehicle']['attributes'])) {
      foreach ($booking_data['vehicle']['attributes'] as $name => $value) {
        // If we have mud we add fee.
        if ($name == 'mud' && $value == 'true') {
          $calculated_price += 2;
        }
      }
    }

    if ($calculated_price != $total_price) {
      return false;
    }
    
    return true;
  }
}
