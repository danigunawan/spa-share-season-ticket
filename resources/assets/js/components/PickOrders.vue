<template>
    <div class="row">
        <div class="col-md-12">
            <h2>Pick Orders</h2>
            <loading :active.sync="loading" :is-full-page="false"></loading>
            <div class="table-responsive" v-if="!isError">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Order</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Picked</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(pick,key) in data">
                        <th scope="row">#{{ key+1 }}</th>
                        <td>{{ pick.participant_extra.participant_name }}</td>
                        <td>{{ pick.participant.email }}</td>
                        <td v-if="pick.schedule_id"><span class="badge badge-success">{{ pick.schedule.name }} {{ pick.schedule.time }}</span></td>
                        <td v-else>
                            <span class="badge badge-danger" v-if="!pick.participant_extra.is_confirmed">NOT CONFIRMED</span>
                            <span class="badge badge-info" v-if="!pick.team.is_picking && pick.participant_extra.is_confirmed">CONFIRMED</span>
                            <span class="badge badge-warning" v-if="pick.team.is_picking && pick.is_picking">TURN TO PICK</span>
                            <span class="badge badge-info" v-if="pick.team.is_picking && !pick.is_picking">NOT TURN TO PICK</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="alert alert-danger" role="alert" v-if="isError">
                Failed to get Participant Details, please try again
            </div>
        </div>
    </div>
</template>

<script>
  // Import component
  import Loading from 'vue-loading-overlay'
  // Import stylesheet
  import 'vue-loading-overlay/dist/vue-loading.min.css'

  import axios from 'axios'

  export default {
    components: {
      Loading
    },

    props: ['guid'],

    computed: {},

    data: () => ({
      isError: false,
      loading: false,
      data: []
    }),

    watch: {},
    mounted () {
      this.fetch()
    },
    methods: {
      async fetch () {
        try {
          this.loading = true
          this.isError = false
          const { data } = await axios.get('/api/teams/' + this.guid + '/picks')
          this.data = data
        } catch (e) {
          console.log(e)
          this.isError = true
        } finally {
          this.loading = false
        }
      }
    }
  }
</script>
