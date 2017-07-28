<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BookingRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
      return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'vehicle.license_plate' => 'required|not_in:1111111',
      'vehicle.type' => 'required|in:truck,car',
      'booking.appointment_date' => 'required|date',
      'booking.total_cost' => 'required|valid_price'
    ];
  }

  /**
   * Format the errors so we can use them more easily.
   */
  public function formatErrors(Validator $validator) {
    $errors = [];
    foreach ($validator->errors()->all() as $error) {
      $errors[] = $error;
    }
    return $errors;
  }

  /**
   * Set our custom error messages.
   */
  public function messages() {
    return [
      'vehicle.license_plate.required' => 'Vehicle license plate is required',
      'vehicle.license_plate.not_in' => 'VEHICLE IS STOLEN! DO NOT WASH, COULD ERASE EVIDENCE!',
      'vehicle.type.required' => 'Vehicle type is required',
      'vehicle.type.in' => 'Vehicle type is invalid',
      'booking.appointment_date.required' => 'Appointment date is required',
      'booking.total_cost.valid_price' => 'Booking price is invalid',
      'booking.total_cost.required' => 'Booking price is required'
    ];
  }
}
