<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img style="width:9rem" src="https://static-contents-smartjen.s3.ap-southeast-1.amazonaws.com/img/smart-jen-logo-horizontal-v3.png" alt="">  
        </a> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link :to="{name: 'home'}" class="nav-link">Home</router-link>
            </li>
          </ul>
          <ul class="navbar-nav">
            <template v-if="isLoggedIn">
              <div v-for="role in user.roles" :key="role.id">
                <li class="nav-item">
                  <router-link :to="{name: role.name}" class="nav-link">{{role.name}}</router-link>
                </li>
              </div>
              <li class="nav-item"><span class="nav-link" style="cursor:pointer" @click="logout">Logout</span></li>
            </template>
            <template v-if="!isLoggedIn">
              <li class="nav-item">
                <router-link :to="{name: 'login'}" class="nav-link">Login</router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{name: 'register'}" class="nav-link">Register</router-link>
              </li>
            </template>
          </ul>
        </div>
      </div>
    </nav>
    <main class="">
      <router-view @loggedIn="setUser"></router-view>
    </main>
  </div>
</template>
<script>
export default {
  data() {
      return {
        user: null,
        isLoggedIn: false
      }
    },
    mounted() {
      this.setUser()
    },
    methods: {
      setUser() {
          this.user = JSON.parse(localStorage.getItem('user'))
          this.isLoggedIn = localStorage.getItem('token') != null

        },
        logout() {
          localStorage.removeItem('token')
          localStorage.removeItem('user')
          this.setUser()

          this.$router.push('/login')
        }
    }
}
</script>