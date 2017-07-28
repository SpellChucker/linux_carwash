<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Vehicle;
use App\VehicleAttribute;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
      return view('booking.index');
    }

    /**
     * This endpoint gets called via AJAX and is populated
     * in a Vue component used on the index route.
     */
    public function loadAll() {
      $bookings = Booking::with('vehicle.attributes')->get()->toArray();

      return json_encode($bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
      return view('booking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request) {
      /**
       * NOTE: Validation is done before getting to this route.
       * Notice the BookingRequest injection which calls the validation
       * for this request.
       */
      $booking_data = $request->all();

      $booking = new Booking;
      $vehicle = new Vehicle;

      $vehicle->type = $booking_data['vehicle']['type'];
      $vehicle->license_plate = $booking_data['vehicle']['license_plate'];

      $vehicle->save();

      // Vehicles may or may not have attributes.
      if (!empty($booking_data['vehicle']['attributes'])) {
        // Save the attributes in the attribute table.
        foreach ($booking_data['vehicle']['attributes'] as $name => $value) {
          if ($value != '') {
            $vehicle_attribute = new VehicleAttribute;
            $vehicle_attribute->name = $name;
            $vehicle_attribute->value = $value;
            $vehicle_attribute->vehicle_id = $vehicle->id;
            $vehicle_attribute->save();
          }
        }
      }

      // Now that we have a saved vehicle, we can associate this booking to the vehicle.
      $booking->appointment_date = date('Y-m-d', strtotime($booking_data['booking']['appointment_date']));
      $booking->total_cost = $booking_data['booking']['total_cost'];
      $booking->vehicle_id = $vehicle->id;
      $booking->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
