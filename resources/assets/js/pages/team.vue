<template>
    <div class="row">
        <div class="col-md-12">
            <h1>Team : {{ guid }}</h1>
            <p class="text-center">
                Here you can view your team picking progress. Keep note of this URL!
            </p>
            <div class="row">
                <div class="col-md-6">
                    <team :guid="guid"></team>
                </div>
                <div class="col-md-6">
                    <participants :guid="guid"></participants>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <pick-orders :guid="guid"></pick-orders>
                </div>
                <div class="col-md-6">
                    <schedule :header="schedules_header" :schedules_url="schedules_url"></schedule>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
  import Team from '~/components/Team'
  import Participants from '../components/Participants'
  import PickOrders from '../components/PickOrders'
  import Schedule from '../components/Schedule'

  export default {
    layout: 'basic',

    metaInfo () {
      return { title: this.$t('home') }
    },

    computed: {
      schedules_url () {
        return '/api/teams/' + this.guid + '/picks/available'
      }
    },

    components: {
      Schedule,
      PickOrders,
      Participants,
      Team
    },

    data: () => ({
      title: window.config.appName,
      guid: '',
      schedules_header: 'Available to Picks'
    }),

    created () {
      this.guid = this.$route.params.guid
    },

    beforeMount () {
      this.fetchTeam()
    },
    methods: {
      async fetchTeam () {
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
