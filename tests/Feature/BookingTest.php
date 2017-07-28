<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingTest extends TestCase {
  /**
   * Ensure the booking create page loads successfully.
   *
   * @return void
   */
  public function testBookingCreatePage() {
    $response = $this->get('/booking/create');

    $response->assertStatus(200);
  }

  /**
   * Ensure the booking listing page loads successfully.
   *
   * @return void
   */
  public function testBookingListingPage() {
    $response = $this->get('/booking');

    $response->assertStatus(200);
  }

  /**
   * Ensure the booking listing JSON enpoint loads successfully.
   *
   * @return void
   */
  public function testBookingListJSON() {
    $response = $this->json('GET', '/booking/loadAll');

    $response->assertStatus(200);
  }

  /**
   * Ensure posting invalid data to create a booking returns a 422.
   *
   * @return void
   */
  public function testBookingCreateFail() {
    $post_json = ['booking' => [], 'vehicle' =>[]];
    $response = $this->json('POST', '/booking', $post_json);

    $response->assertStatus(422)
      ->assertJson([
        "Vehicle license plate is required",
        "Vehicle state is required",
        "Vehicle type is required",
        "Appointment date is required",
        "Booking price is required"
      ]);
  }

  /**
   * Ensure posting valid data to create a booking returns a 200.
   *
   * @return void
   */
  public function testBookingCreatePass() {
    $post_json = [
      'booking' => [
        'appointment_date' => '2017-07-27',
        'total_cost' => '10'
      ], 'vehicle' => [
        'type' => 'truck',
        'license_plate' => '123123',
        'state' => 'TX'
      ]
    ];
    $response = $this->json('POST', '/booking', $post_json);

    $response->assertStatus(200);
  }

  /**
   * Ensure posting same vehicle twice gives discount.
   *
   * @return void
   */
  public function testBookingCreateMultiple() {
    $post_json = [
      'booking' => [
        'appointment_date' => '2017-07-27',
        'total_cost' => '10'
      ], 'vehicle' => [
        'type' => 'truck',
        'license_plate' => '123123',
        'state' => '123123'
      ]
    ];

    $response = $this->json('POST', '/booking', $post_json);

    $response = $this->json('POST', '/booking', $post_json);

    $response->assertStatus(200)
      ->assertJson([
        'message' => 'Booking saved with a 50% discount!'
      ]);;
  }
}
