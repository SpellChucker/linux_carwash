
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-datepicker');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Set-up Vue to use axios.
Vue.prototype.$http = axios;

// This is our main booking component handling submission of bookings for car washes.
Vue.component('bookingcreate', require('./components/BookingCreate.vue'));

// This is our booking listing component.
Vue.component('bookinglisting', require('./components/BookingListing.vue'));

const app = new Vue({
    el: '#app'
});
