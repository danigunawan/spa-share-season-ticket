<template>
    <div class="row">
        <div class="col-md-12">
            <h2>Participants List</h2>
            <loading :active.sync="loading" :is-full-page="false"></loading>
            <div class="table-responsive" v-if="!isError">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                    <tr v-for="participant in data">
                        <td>{{ participant.name }}</td>
                        <td>{{ participant.email }}</td>
                        <td v-if="participant.confirmed_at"><span class="badge badge-success">CONFIRMED</span></td>
                        <td v-else><span class="badge badge-warning">NOT CONFIRMED</span></td>
                    </tr>
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
      data: [],
      team: {}
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
          const { data } = await axios.get('/api/teams/' + this.guid + '/participants')
          this.team = data.team
          this.data = data.participants
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
