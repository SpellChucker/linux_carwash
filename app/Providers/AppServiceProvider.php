<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider {
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot() {
    // This is set for the key issue outlined here: https://laravel-news.com/laravel-5-4-key-too-long-error
    Schema::defaultStringLength(191);

    // Set-up a custom validator to ensure the price is valid for a booking.
    Validator::extend('valid_price', 'App\Validators\BookingValidator@validate');
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register() {
      //
  }
}
