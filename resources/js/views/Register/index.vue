<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-sm-5 mx-sm-auto col-12">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="card-title">Register Youre Schools</h4>
            <hr />
            <div v-if="errors" class="alert bg-danger text-white">
              <div v-for="(v, k) in errors" :key="k">
                <p v-for="error in v" :key="error" class="text-sm">
                  {{ error }}
                </p>
              </div>
            </div>
            <form @submit.prevent="submitForm">
              <div class="mb-3">
                <input
                  type="text"
                  v-model="user.name"
                  placeholder="Shools Name"
                  class="form-control"
                  id="name"
                />
              </div>
              <div class="mb-3">
                <input
                  type="email"
                  v-model="user.email"
                  placeholder="Email"
                  class="form-control"
                  id="email"
                />
              </div>
              <div class="mb-3">
                <input
                  type="password"
                  v-model="user.password"
                  placeholder="password"
                  class="form-control"
                  id="password"
                />
              </div>
              <div class="mb-3">
                <input
                  type="password"
                  v-model="user.password_confirmation"
                  placeholder="Confirm Password"
                  class="form-control"
                  id="password_confirmation"
                />
              </div>
              <button type="submit" class="btn btn-primary w-100">
                Register
              </button>
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
      user: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        role: 1,
      },
      errors: null,
    };
  },
  created() {
    document.title = "SmartJen Register";
  },
  methods: {
    submitForm() {
      axios
        .post("api/register", this.user)
        .then((response) => {
          this.$router.push({
            name: "login",
            params: {
              message: response.data.message,
            },
          });
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
  },
};
</script>