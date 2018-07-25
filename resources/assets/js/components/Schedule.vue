<template>
    <div class="row">
        <div class="col-md-12">
            <h2>{{ header }}</h2>
            <loading :active.sync="loading" :is-full-page="false"></loading>
            <div class="table-responsive" v-if="!isError">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Match</th>
                            <th>Schedule</th>
                        </tr>
                        <tr v-for="(value, key) in schedules">
                            <td>{{ value.name }}</td>
                            <td>{{ value.time }}</td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="alert alert-danger" role="alert" v-if="isError">
                Failed to get Schedules Details, please try again
            </div>
        </div>
    </div>
</template>

<script>
  // Import component
  import Loading from 'vue-loading-overlay'
  import axios from 'axios'
  // Import stylesheet
  import 'vue-loading-overlay/dist/vue-loading.min.css'

  export default {
    components: {
      Loading
    },

    props: ['schedules_url', 'header'],

    computed: {},

    data: () => ({
      isError: false,
      loading: false,
      schedules: []
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
          const { data } = await axios.get(this.schedules_url)
          this.schedules = data
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
