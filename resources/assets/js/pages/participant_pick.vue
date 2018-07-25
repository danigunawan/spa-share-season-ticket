<template>
    <div class="row">
        <div class="col-md-12">
            <h2>Participants Pick</h2>
            <loading :active.sync="loading" :is-full-page="false"></loading>
            <div class="alert alert-danger" role="alert" v-if="team_pick.isError">
                Failed to Confirm, Please try again
            </div>
            <div class="alert alert-success" role="alert" v-if="team_pick.isSuccess">
                Picked!
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
    layout: 'basic',

    metaInfo () {
      return { title: this.$t('home') }
    },

    components: {
      Loading
    },

    data: () => ({
      title: window.config.appName,
      guid: '',
      schedule_id: '',
      loading: false,
      team_pick: {}
    }),

    created () {
      this.guid = this.$route.params.guid
      this.schedule_id = this.$route.params.schedule_id
    },

    beforeMount () {
      this.pickParticipant()
    },
    methods: {
      async pickParticipant () {
        try {
          this.loading = true
          this.team_pick = {}
          const { data } = await axios.post('/api/participants/pick/' + this.guid + '/' + this.schedule_id, {})
          this.team_pick = data
          this.team_pick.isSuccess = true
          // Redirect team.
          this.$router.push({
            name: 'team', params: { guid: this.team_pick.team.guid }
          })
        } catch (e) {
          console.log(e)
          this.team_pick.isError = true
        } finally {
          this.loading = false
        }
      }
    }
  }
</script>

<style scoped>
    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .title {
        font-size: 85px;
    }
</style>
