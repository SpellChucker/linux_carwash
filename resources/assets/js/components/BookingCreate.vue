<template>
  <div>
    <form @submit.prevent="submitBooking">
      <div v-if="errors.length" class="alert alert-danger">
        <li v-for="error in errors">{{ error }}</li>
      </div>
      <div v-if="success" class="alert alert-success">
        Booking successfully saved!
      </div>
      <div v-if="vehicle.attributes.bed_down == 'true'" class="alert alert-info">Trucks with the bed down are not allowed!</div>
      <div class="form-group">
        <label for="vehicle_type">Vehicle type</label>
        <br />
        <label class="radio-inline">
          <input @change="calculateEstimatedTotal" v-model="vehicle.type" type="radio" name="vehicle_type" value="car" required> Car
        </label>
        <label class="radio-inline">
          <input @change="calculateEstimatedTotal" v-model="vehicle.type" type="radio" name="vehicle_type" value="truck"> Truck
        </label>
      </div>
      <div v-if="vehicle.type == 'truck'" class="form-group">
        <label for="vehicle_type">Is the truck bed down?</label>
        <br />
        <label class="radio-inline">
          <input v-model="vehicle.attributes.bed_down" type="radio" name="bed_down" value="true"> Yes
        </label>
        <label class="radio-inline">
          <input v-model="vehicle.attributes.bed_down" type="radio" name="bed_down" value="false"> No
        </label>
      </div>
      <div v-if="vehicle.type == 'truck'" class="form-group">
        <label for="vehicle_type">Is there mud in the truck bed?</label>
        <br />
        <label class="radio-inline">
          <input @change="calculateEstimatedTotal" v-model="vehicle.attributes.mud" type="radio" name="mud" value="true"> Yes
        </label>
        <label class="radio-inline">
          <input @change="calculateEstimatedTotal" v-model="vehicle.attributes.mud" type="radio" name="mud" value="false"> No
        </label>
        <div v-if="vehicle.attributes.mud == 'true'" class="notice-warning">This incurs a {{ money(mud_cost) }} charge.</div>
      </div>
      <div class="form-group">
        <label for="license_plate">License plate</label>
        <input v-model="vehicle.license_plate" type="text" maxlength="8" placeholder="License Plate Number" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="appointment_date">Appointment Date</label>
        <input v-model="booking.appointment_date" id="appointment_date" class="form-control datepicker" placeholder="Appointment Date" required>
      </div>
      <div class="form-group">
        <label for="cost">Total Cost</label>
        {{ money(booking.total_cost) }}
      </div>
      <button class="btn btn-primary" v-if="vehicle.attributes.bed_down == 'false' || vehicle.attributes.bed_down == ''">Submit Booking</button>
    </form>
  </div>
</template>

<script>
  var moment = require('moment')
  export default {
    components: {
      datepicker
    },
    data () {
      return {
        booking: {
          appointment_date: '',
          total_cost: 0
        },
        vehicle: {
          type: '',
          license_plate: '',
          attributes: {
            mud: '',
            bed_down: ''
          }
        },
        date_range: {
          disabled: {
            to: moment().add(-1, 'days').toDate()
          }
        },
        mud_cost: 2,
        car_cost: 5,
        truck_cost: 10,
        success: false,
        errors: []
      }
    },
    mounted () {
      $('.datepicker').datepicker({
        autoclose: true,
        startDate: moment().add(-1, 'days').toDate()
      }).on('changeDate', () => { this.booking.appointment_date = $('#appointment_date').val() });
    },
    methods: {
      calculateEstimatedTotal () {
        this.booking.total_cost = 0

        if (this.vehicle.type == "car") {
          this.booking.total_cost += this.car_cost
          this.vehicle.attributes.mud = ''
          this.vehicle.attributes.bed_down = ''
        } else if (this.vehicle.type == "truck") {
          this.booking.total_cost += this.truck_cost
          if (this.vehicle.attributes.mud == 'true') {
            this.booking.total_cost += this.mud_cost
          }
        }
      },
      money (number) {
        return '$' + Number(number).toFixed(2);
      },
      submitBooking() {
        let vm = this
        this.errors = []
        this.success = false

        let data = {
          booking: this.booking,
          vehicle: this.vehicle
        }

        this.$http.post('/booking', data).then(function(response) {
          // Successfully submitted booking. Let the user know.
          vm.success = true
          // Reset data. A better way would be to create a form object here
          // which has a method to reset all data.
          vm.vehicle = {
            type: '',
            license_plate: '',
            attributes: {
              mud: '',
              bed_down: ''
            }
          }

          vm.booking = {
            appointment_date: '',
            total_cost: 0
          }
        }).catch(function(error) {
          // We'll get here if we get a validation error on submit.
          vm.errors = error.response.data
        });
      }
    }
  }
</script>

<style lang="scss" scoped>
.notice-warning {
  font-size: 11px;
  color: #a94442;
}
</style>
