<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-sm-5 mx-sm-auto col-12">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="card-title">Login</h4>
            <hr />
            <div v-if="error" class="alert bg-danger text-white">
              {{ error }}
            </div>
            <div v-if="errors" class="alert bg-danger text-white">
              <div v-for="(v, k) in errors" :key="k">
                <p v-for="error in v" :key="error" class="text-sm">
                  {{ error }}
                </p>
              </div>
            </div>
            <form @submit.prevent="loginForm">
              <div class="mb-3">
                <input
                  type="email"
                  v-model="email"
                  class="form-control"
                  placeholder="Email"
                  id="email"
                />
              </div>
              <div class="mb-3">
                <input
                  type="password"
                  v-model="password"
                  class="form-control"
                  placeholder="Password"
                  id="password"
                />
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
 
<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      errors: null,
      error: null,
      message: "",
    };
  },
  created() {
    document.title = "SmartJen Login";
    if (this.$route.params.message !== undefined) {
      this.message = this.$route.params.message + " Please login!";
    }
  },
  methods: {
    loginForm() {
      axios
        .post("api/login", {
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          localStorage.setItem("user", JSON.stringify(response.data.user));
          localStorage.setItem("token", response.data.token);
          let loginType = response.data.user.roles[0].name;
          console.log(loginType);
          if (loginType === "STUDENT") {
            this.$router.push("student");
          } else if (loginType === "ADMIN") {
            this.$router.push("admin");
          } else if (loginType === "TEACHER") {
            this.$router.push("teacher");
          } else {
            this.$router.push("home");
          }
          this.$emit("loggedIn");
        })
        .catch((error) => {
          if (error.response.data.errors == undefined) {
            this.error = error.response.data.error;
          } else {
            this.errors = error.response.data.errors;
          }
        });
    },
  },
};
</script>