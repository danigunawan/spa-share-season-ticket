<template>
    <div class="row">
        <div class="col-md-12">
            <h2>Draft Details</h2>
            <loading :active.sync="loading" :is-full-page="false"></loading>
            <div class="table-responsive" v-if="!isError">
                <table class="table">
                    <tr>
                        <th>GUID</th>
                        <td>{{ team.guid }}</td>
                    </tr>
                    <tr>
                        <th>Seat Row</th>
                        <td>{{ team.seat_row }}</td>
                    </tr>
                    <tr>
                        <th>Seat Section</th>
                        <td>{{ team.seat_section }}</td>
                    </tr>
                    <tr>
                        <th>Complete Status</th>
                        <td v-if="team.is_complete"><span class="badge badge-success">COMPLETE</span></td>
                        <td v-else><span class="badge badge-warning">NOT COMPLETE</span></td>
                    </tr>
                    <tr>
                        <th>Confirmed Status</th>
                        <td v-if="team.is_all_confirmed"><span class="badge badge-success">CONFIRMED</span></td>
                        <td v-else><span class="badge badge-warning">SOME PARTICIPANT NOT CONFIRMED YET</span></td>
                    </tr>
                    <tr>
                        <th>Picking Status</th>
                        <td v-if="team.is_picking"><span class="badge badge-info">PICKING</span></td>
                        <td v-else><span class="badge badge-warning">NOT PICKING</span></td>
                    </tr>
                    <tr>
                        <th>Link</th>
                        <td>
                            <router-link :to="{ name: 'team', params: { guid: guid }}">{{ $route.fullPath }}</router-link>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="alert alert-danger" role="alert" v-if="isError">
                Failed to get Draft Details, please try again
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
  import Participants from './Participants'

  export default {
    components: {
      Participants,
      Loading
    },

    props: ['guid'],

    computed: {},

    data: () => ({
      isError: false,
      loading: false,
      team: {}
    }),

    watch: {},
    mounted () {
      this.fetchTeam()
    },
    methods: {
      async fetchTeam () {
        try {
          this.loading = true
          this.isError = false
          const { data } = await axios.get('/api/teams/' + this.guid)
          this.team = data
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
