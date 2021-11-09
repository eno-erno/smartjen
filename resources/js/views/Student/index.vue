<template>
  <div class="container mt-5">
    <div class="row align-items-md-stretch">
      <div class="col-md-12">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h1>
            Welcome, Student <strong>{{ school }}</strong>
          </h1>
          <h6>{{ studentName }}</h6>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12 col-sm-6">
          <h2>
            All Student <strong>{{ school }}</strong>
          </h2>
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Name</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(rows, index) in students" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ rows.student }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-12 col-sm-6">
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Chat Room
                    </div>
                    <div class="card-contant">
                        <div class="wrapChat py-4">
                            <div class="row">
                                <div class="col-12 text-start">
                                    <div class="chatting px-2 w-50 bg-info text-white p-3 rounded">
                                        My teacher
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="chatting px-2 w-50 text-end ms-auto bg-secondary p-3 text-white rounded">
                                        My student
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-contant pt-4">
                        <form action="">
                            <div class="d-flex">
                                <textarea name="" rows="1" class="form-control me-2" placeholder="Input Message"></textarea>
                                <button class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
      user: "",
      loginType: "",
      school: "",
      students: [],
      studentName: "",
    };
  },
  methods: {
    async getStudent() {
      this.getToken();
      await axios
        .get(`/api/user-by-admin`)
        .then((response) => {
          this.students = response.data.data.getStudent;
          this.studentName = response.data.data.student.student.toUpperCase();
        })
        .catch((error) => {
          if (error.response.status === 401) {
            localStorage.clear();
            this.$router.push("/login");
          }
        });
    },
    getToken() {
      axios.defaults.headers.common["Content-Type"] = "application/json";
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + localStorage.getItem("token");
    },
    async getUserLogin() {
      this.getToken();
      axios
        .get(`/api/user`)
        .then((response) => {
          this.user = response.data;
          this.loginType = response.data.roles[0].name;
          this.school = response.data.Schools.name;
          console.log(response.data.Schools.name);
        })
        .catch((error) => {
          if (error.response.status === 401) {
            localStorage.clear();
            this.$router.push("/login");
          }
          console.error(error);
        });
    },
  },
  created() {
    this.getStudent();
    this.getUserLogin();
  },
};
</script>
<style scoped>
.wrapChat {
  height: 350px;
  overflow: auto;
}
</style>

