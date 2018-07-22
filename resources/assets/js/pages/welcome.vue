<template>
    <div>
        <!--<div class="top-right links">-->
        <!--<template v-if="authenticated">-->
        <!--<router-link :to="{ name: 'home' }">-->
        <!--{{ $t('home') }}-->
        <!--</router-link>-->
        <!--</template>-->
        <!--<template v-else>-->
        <!--<router-link :to="{ name: 'login' }">-->
        <!--{{ $t('login') }}-->
        <!--</router-link>-->
        <!--</template>-->
        <!--</div>-->

        <!--<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">-->
        <!--<div class="carousel-inner">-->
        <!--<div class="carousel-item active">-->
        <!--<img class=" w-100 h-50" src="http://fansfirst.dev.my.id/img/chair.jpg" alt="First slide">-->
        <!--<div class="carousel-caption d-none d-md-block">-->
        <!--<img class="center-block" src="http://fansfirst.dev.my.id/img/logo.png">-->
        <!--<h5>HELPS FRIENDS SHARE A SET OF SEASON TICKETS IN THE MOST FAIR WAY POSSIBLE</h5>-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->

        <hr>
        <h2 class="text-center">CALGARY FLAMES UPCOMING SEASON</h2>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <create-team/>
            </div>
            <div class="col-md-6">
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
        </div>

    </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import axios from 'axios'
  import CreateTeam from '~/components/CreateTeam'

  export default {
    layout: 'basic',

    metaInfo () {
      return { title: this.$t('home') }
    },

    computed: mapGetters({
      authenticated: 'auth/check'
    }),

    components: {
      CreateTeam
    },

    data: () => ({
      title: window.config.appName,
      schedules: []
    }),

    beforeMount () {
      this.fetchShcedules()
    },
    methods: {
      async fetchShcedules () {
        try {
          const { data } = await axios.get('api/schedules?limit=45')
          this.schedules = data.data
        } catch ( e ) {

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
