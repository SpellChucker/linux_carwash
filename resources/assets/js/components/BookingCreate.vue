<template>
  <div>
    <form @submit.prevent="submitBooking">
      <div v-if="errors.length" class="alert alert-danger">
        <li v-for="error in errors">{{ error }}</li>
      </div>
      <div v-if="success_message.length" class="alert alert-success">
        {{ success_message }}
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
        <label for="license_plate">Vehicle State</label>
        <select v-model="vehicle.state" class="form-control" required>
          <option value="">-- Select a State --</option>
          <option value="AK">Alaska</option>
          <option value="AL">Alabama</option>
          <option value="AR">Arkansas</option>
          <option value="AZ">Arizona</option>
          <option value="CA">California</option>
          <option value="CO">Colorado</option>
          <option value="CT">Connecticut</option>
          <option value="DC">District of Columbia</option>
          <option value="DE">Delaware</option>
          <option value="FL">Florida</option>
          <option value="GA">Georgia</option>
          <option value="HI">Hawaii</option>
          <option value="IA">Iowa</option>
          <option value="ID">Idaho</option>
          <option value="IL">Illinois</option>
          <option value="IN">Indiana</option>
          <option value="KS">Kansas</option>
          <option value="KY">Kentucky</option>
          <option value="LA">Louisiana</option>
          <option value="MA">Massachusetts</option>
          <option value="MD">Maryland</option>
          <option value="ME">Maine</option>
          <option value="MI">Michigan</option>
          <option value="MN">Minnesota</option>
          <option value="MO">Missouri</option>
          <option value="MS">Mississippi</option>
          <option value="MT">Montana</option>
          <option value="NC">North Carolina</option>
          <option value="ND">North Dakota</option>
          <option value="NE">Nebraska</option>
          <option value="NH">New Hampshire</option>
          <option value="NJ">New Jersey</option>
          <option value="NM">New Mexico</option>
          <option value="NV">Nevada</option>
          <option value="NY">New York</option>
          <option value="OH">Ohio</option>
          <option value="OK">Oklahoma</option>
          <option value="OR">Oregon</option>
          <option value="PA">Pennsylvania</option>
          <option value="PR">Puerto Rico</option>
          <option value="RI">Rhode Island</option>
          <option value="SC">South Carolina</option>
          <option value="SD">South Dakota</option>
          <option value="TN">Tennessee</option>
          <option value="TX">Texas</option>
          <option value="UT">Utah</option>
          <option value="VA">Virginia</option>
          <option value="VT">Vermont</option>
          <option value="WA">Washington</option>
          <option value="WI">Wisconsin</option>
          <option value="WV">West Virginia</option>
          <option value="WY">Wyoming</option>
        </select>
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
    data () {
      return {
        booking: {
          appointment_date: '',
          total_cost: 0
        },
        vehicle: {
          type: '',
          license_plate: '',
          state: '',
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
        success_message: '',
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
          vm.success_message = response.data.message
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
