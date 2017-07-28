<template>
  <div>
    <table class="table">
      <tr>
        <th>Booking Time</th>
        <th>Vehicle Type</th>
        <th>Vehicle Attributes</th>
        <th>Total Cost</th>
      </tr>
      <tr v-for="booking in bookings">
        <td>{{ booking.appointment_date }}</td>
        <td>{{ booking.vehicle.type }}</td>
        <td>{{ attrList(booking.vehicle.attributes) }}</td>
        <td>{{ money(booking.total_cost) }}</td>
      </tr>
      <tr v-if="bookings.length == 0">
        <td colspan="4">No bookings found</td>
      </tr>
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
          attrList += attribute.name + ': ' + attribute.value + '\n'
        });

        return attrList
      },
      money(amount) {
        return '$' + Number(amount).toFixed(2)
      }
    }
  }
</script>
