<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('bookings', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('vehicle_id');
        $table->date('appointment_date');
        $table->float('total_cost', 8, 2);
        $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('bookings');
  }
}
