<template>
  <div>
    <table class="table table-responsive">
      <thead>
        <tr>
          <th>Booking Time</th>
          <th>Vehicle Type</th>
          <th>Vehicle License Plate</th>
          <th>Vehicle State</th>
          <th>Vehicle Attributes</th>
          <th>Total Cost</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="booking in bookings">
          <td>{{ booking.appointment_date }}</td>
          <td>{{ ucfirst(booking.vehicle.type) }}</td>
          <td>{{ booking.vehicle.license_plate }}</td>
          <td>{{ booking.vehicle.state }}</td>
          <td><div v-html="attrList(booking.vehicle.attributes)"></div></td>
          <td>{{ money(booking.total_cost) }}</td>
        </tr>
        <tr v-if="bookings.length == 0">
          <td colspan="4">No bookings found</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  var moment = require('moment')
  export default {
    data () {
      return {
        bookings: []
      }
    },
    mounted() {
      let vm = this;

      // When we're ready, grab all the bookings.
      this.$http.get('/booking/loadAll').then(function(response) {
        vm.bookings = response.data;
      }).catch(function(error) {

      });
    },
    methods: {
      attrList(attributes) {
        let attrList = ''
        attributes.forEach(function(attribute) {
          attrList += attribute.name + ': ' + attribute.value + '<br />'
        });

        return attrList
      },
      money(amount) {
        return '$' + Number(amount).toFixed(2)
      },
      ucfirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
      }
    }
  }
</script>
