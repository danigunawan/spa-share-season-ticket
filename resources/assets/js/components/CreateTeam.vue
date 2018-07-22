<template>
    <div>
        <loading :active.sync="form.busy" :is-full-page="false"></loading>
        <alert-errors :form="form">There were some problems with your input.</alert-errors>
        <vue-good-wizard
                :steps="steps"
                :onNext="nextClicked"
                :onBack="backClicked">

            <div slot="step1">
                <h4>Seat Details</h4>
                <!-- Name -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Seat Row</label>
                    <div class="col-md-7">
                        <input v-model="form.seat_row" type="text" name="seat_row" class="form-control" :required="true"
                               :class="{ 'is-invalid': form.errors.has('seat_row') }">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Seat Section</label>
                    <div class="col-md-7">
                        <input v-model="form.seat_section" type="text" name="seat_section" class="form-control" :required="true"
                               :class="{ 'is-invalid': form.errors.has('seat_section') }">
                    </div>
                </div>
            </div>
            <div slot="step2">
                <h4>Participants</h4>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Number of Participants</label>
                    <div class="col-md-7">
                        <select v-model="num_participant" name="num_participant" class="form-control" :required="true"
                                :class="{ 'is-invalid': form.errors.has('num_participant') }">
                            <option v-for="value in num_participants" :value="value">{{ value }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div slot="step3">
                <h4>Participants Detail</h4>

                <div v-for="value in num_participant" class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Name #{{ value }}</label>
                    <div class="col-md-7">
                        <input v-model="form.participant_names[value-1]" type="text" name="participant_names[]" class="form-control" :required="true"
                               :class="{ 'is-invalid': form.errors.has('participant_names') }"/>
                    </div>
                    <label class="col-md-3 col-form-label text-md-right">Email #{{ value }}</label>
                    <div class="col-md-7">
                        <input v-model="form.participant_emails[value-1]" type="email" name="participant_emails[]" class="form-control" :required="true"
                               :class="{ 'is-invalid': form.errors.has('participant_emails') }"/>
                    </div>
                </div>

            </div>
            <div slot="step4">
                <h4>Review</h4>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">Seat Row</th>
                            <td colspan="2">{{ form.seat_row }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Seat Section</th>
                            <td colspan="2">{{ form.seat_section }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Num Particpiant</th>
                            <td colspan="2">{{ num_participant }}</td>
                        </tr>
                        <tr>
                            <th scope="row" :rowspan="num_participant">Participants</th>
                            <td>{{ firstParticipant.name }}</td>
                            <td>{{ firstParticipant.email }}</td>
                        </tr>
                        <tr>
                            <td v-for="value in filterParticipantNamesByIndex(0)">{{ value }}</td>
                            <td v-for="value in filterParticipantEmailsByIndex(0)">{{ value }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </vue-good-wizard>
    </div>
</template>

<script>
  import Form from 'vform'
  import { GoodWizard } from 'vue-good-wizard'
  import swal from 'sweetalert2'
  // Import component
  import Loading from 'vue-loading-overlay'
  // Import stylesheet
  import 'vue-loading-overlay/dist/vue-loading.min.css'

  export default {
    components: {
      'vue-good-wizard': GoodWizard,
      Loading
    },

    computed: {
      firstParticipant () {
        return {
          name: (this.form.participant_names.length > 0 ? this.form.participant_names[0] : ''),
          email: (this.form.participant_emails.length > 0 ? this.form.participant_emails[0] : '')
        }
      }
    },

    data: () => ({
      steps: [
        {
          label: 'Seat Details',
          slot: 'step1'
        },
        {
          label: 'Participants',
          slot: 'step2'
        },
        {
          label: 'Participant Details',
          slot: 'step3'
        },
        {
          label: 'Review',
          slot: 'step4',
          options: {}
        }
      ],
      form: new Form({
        seat_row: '',
        seat_section: '',
        participant_names: [],
        participant_emails: []
      }),
      num_participant: 2,
      num_participants: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
      loading: false
    }),

    watch: {
      num_participant (val) {
        if (this.form.participant_names.length > val) {
          const newParticipantNames = []
          const newParticipantEmails = []
          for (let i = 0; i < val; i++) {
            newParticipantNames.push(this.form.participant_names[i])
            newParticipantEmails.push(this.form.participant_emails[i])
          }
          this.form.participant_names = newParticipantNames
          this.form.participant_emails = newParticipantEmails
        }
      }
    },

    methods: {
      nextClicked (currentPage) {
        if (currentPage === 0) {
          if (!this.form.seat_row || !this.form.seat_section) {
            swal({
              type: 'error',
              title: 'Invalid Seat Details',
              text: 'Please enter seat details',
              reverseButtons: true,
              confirmButtonText: 'OK',
              cancelButtonText: 'Cancel'
            })
            return false
          }
        } else if (currentPage === 1) {
          if (this.num_participant < 2 || this.num_participant > 15) {
            swal({
              type: 'error',
              title: 'Invalid Participant',
              text: 'Please enter valid Participant',
              reverseButtons: true,
              confirmButtonText: 'OK',
              cancelButtonText: 'Cancel'
            })
            return false
          }
        } else if (currentPage === 2) {
          if (this.form.participant_emails.length !== this.form.participant_names.length) {
            this.showAlert('error', 'Invalid Participant Details', 'Please enter valid Participant Details')
            return false
          }
          if (this.form.participant_emails.length !== this.num_participant) {
            this.showAlert('error', 'Invalid Participant Details', 'Please enter valid Participant Details')
            return false
          }
        } else if (currentPage === 3) {
          this.registerTeam()
          return false
        }
        return true
      },
      backClicked (currentPage) {
        return true
      },
      async registerTeam () {
        try {
          const { data } = await this.form.post('api/teams/register')
          this.form.reset()
          this.num_participant = 2
          // Redirect team.
          this.$router.push({
            name: 'team', params: { guid: data.guid }
          })
        } catch (e) {
          this.showAlert('error', 'Register Failed', 'Register Team Failed')
        } finally {
        }
      },
      showAlert (type, message, messageDesc) {
        swal({
          type: type,
          title: message,
          text: messageDesc,
          reverseButtons: true,
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel'
        })
      },
      filterParticipantNamesByIndex (index) {
        return this.form.participant_names.filter((participantName, i) => index !== i)
      },
      filterParticipantEmailsByIndex (index) {
        return this.form.participant_emails.filter((participantEmails, i) => index !== i)
      }
    }
  }
</script>
