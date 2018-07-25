<template>
    <div class="row">
        <div class="col-md-12">
            <h2>Participants Confirmation</h2>
            <loading :active.sync="loading" :is-full-page="false"></loading>
            <div class="alert alert-danger" role="alert" v-if="participant.isError">
                Failed to Confirm, Please try again
            </div>
            <div class="alert alert-success" role="alert" v-if="participant.isSuccess">
                Confirmed!
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
      loading: false,
      participant: {}
    }),

    created () {
      this.guid = this.$route.params.guid
    },

    beforeMount () {
      this.confirmParticipant()
    },
    methods: {
      async confirmParticipant () {
        try {
          this.loading = true
          this.participant = {}
          const { data } = await axios.post('/api/participants/' + this.guid + '/confirm', {})
          this.participant = data
          this.participant.isSuccess = true
          // Redirect team.
          this.$router.push({
            name: 'team', params: { guid: this.participant.team.guid }
          })
        } catch (e) {
          console.log(e)
          this.participant.isError = true
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
