<template>
  <div>
        <div id="wrapper" v-if="dontDisplay">
                <Sidebar />
                <div id="content-wrapper" class="d-flex flex-column">
                    <div id="content">
                        <Navbar />
                        <router-view></router-view>
                    </div>
                    <Footer />
                </div>
        </div>
        <router-view  v-if="!dontDisplay" />
  </div>
</template>

<script>
  import Navbar from './components/Navbar';
  import Sidebar from './components/Sidebar';
  import Footer from './components/Footer';
  export default {
    components: {
      Navbar,
      Sidebar,
      Footer
    },
     data () {
        return {
        login: '/login',
        register: '/register',
        // register2: '/register-organizer'
        }
    },
    computed: {
        dontDisplay () {
            return this.$route.path !== this.login &&  this.$route.path !== this.register
        }
    }
  }
</script>
