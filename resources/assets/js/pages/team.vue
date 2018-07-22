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
                    Available To Picks
                </div>
            </div>

        </div>
    </div>

</template>

<script>
  import { mapGetters } from 'vuex'
  import Team from '~/components/Team'
  import Participants from '../components/Participants'
  import PickOrders from '../components/PickOrders'

  export default {
    layout: 'basic',

    metaInfo () {
      return { title: this.$t('home') }
    },

    computed: mapGetters({
      authenticated: 'auth/check'
    }),

    components: {
      PickOrders,
      Participants,
      Team
    },

    data: () => ({
      title: window.config.appName,
      guid: ''
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
