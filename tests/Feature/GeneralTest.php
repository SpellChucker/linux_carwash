<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GeneralTest extends TestCase {
  /**
   * Ensure the home page loads successfully.
   *
   * @return void
   */
  public function testHomePage() {
    $response = $this->get('/');

    $response->assertStatus(200);
  }
}
