<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-12">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h1>
            Dashboard, <strong>{{ schools }}</strong>
          </h1>
          <h3></h3>
        </div>
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-sm btn-dark" @click="handleTabs('student')">
        Student
      </button>
      <button class="btn btn-sm btn-dark" @click="handleTabs('teacher')">
        Teacher
      </button>
    </div>
    <div class="row" v-if="tabsSrudent">
      <div class="col-12 col-sm-6">
        <h2 class="bg-white shadow mt-3 p-3">Student</h2>
        <div class="col-sm-6">
          <div class="alert alert-primary" role="alert" v-if="message">
            {{ message }}
          </div>
        </div>
        <div v-if="errors" class="alert bg-danger text-white">
          <div v-for="(v, k) in errors" :key="k">
            <p v-for="error in v" :key="error" class="text-sm">
              {{ error }}
            </p>
          </div>
        </div>
        <form v-on:submit.prevent="submitForm" class="p-3 shadow mt-4">
          <div class="form-group">
            <label for="name">Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Your name"
              v-model="form.name"
            />
          </div>
          <div class="form-group mb-3">
            <label for="email">Email</label>
            <input
              type="text"
              class="form-control"
              id="email"
              placeholder="Your email"
              v-model="form.email"
            />
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-sm">{{btnStatus ? 'Submit' : 'Update'}}</button>
            <button class="btn btn-warning btn-sm" type="button" v-if="btnStatus === false" @click="handleCancelForm">Cancel</button>
          </div>
        </form>
        <table class="table mt-5">
          <thead>
            <tr>
              <th>No</th>
              <th>Name Student</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(rows, index) in students" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ rows.student }}</td>
              <td>{{ rows.email }}</td>
              <td>
                <span
                  class="badge bg-danger"
                  @click="handleDelete(rows.id, 'STUDENT')"
                >
                  Delete
                </span>
                <span
                  class="badge bg-info"
                  @click="handleUpdate(rows, 'STUDENT')"
                >
                  Update
                </span>
                <span
                  class="badge bg-primary"
                  @click="handleInvite(rows, 'STUDENT')"
                >
                  Invite
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row" v-if="tabsTheacer">
      <div class="col-12 col-sm-6">
        <h2 class="bg-white shadow mt-3 p-3">Teacher</h2>
        <div class="alert alert-primary" role="alert" v-if="messageTeacher">
          {{ messageTeacher }}
        </div>
        <div v-if="errorsTeacer" class="alert bg-danger text-white">
          <div v-for="(v, k) in errorsTeacer" :key="k">
            <p v-for="error in v" :key="error" class="text-sm">
              {{ error }}
            </p>
          </div>
        </div>
        <form v-on:submit.prevent="submitFormTeacher" class="p-3 shadow mt-4">
          <div class="form-group">
            <label for="name">Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Your name"
              v-model="formTeacher.name"
            />
          </div>
          <div class="form-group mb-3">
            <label for="email">Email</label>
            <input
              type="text"
              class="form-control"
              id="email"
              placeholder="Your email"
              v-model="formTeacher.email"
            />
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-sm">{{btnStatusTeacher ? 'Submit' : 'Update'}}</button>
            <button class="btn btn-warning btn-sm" type="button" v-if="btnStatusTeacher === false" @click="handleCancelForm">Cancel</button>
          </div>
        </form>
        <table class="table mt-5">
          <thead>
            <tr>
              <th>No</th>
              <th>Name Teacher</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(rows, index) in teachers" :key="rows.id">
              <td>{{ index + 1 }}</td>
              <td>{{ rows.teacher }}</td>
              <td>{{ rows.email }}</td>
              <td>
                <span
                  class="badge bg-danger"
                  @click="handleDelete(rows.id, 'TEACHER')"
                >
                  Delete
                </span>
                <span
                  class="badge bg-info"
                  @click="handleUpdate(rows, 'TEACHER')"
                >
                  Update
                </span>
                <span
                  class="badge bg-primary"
                  @click="handleInvite(rows, 'TEACHER')"
                >
                  Invite
                </span>
              </td>
            </tr>
          </tbody>
        </table>
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
      schools: "",
      students: [],
      teachers: [],
      modalShow: false,
      form: {
        name: '',
        email: ''
      },
      formTeacher: {
        name: '',
        email: ''
      },
      message: "",
      messageTeacher: "",
      errors: null,
      errorsTeacer: null,
      name: null,
      email: null,
      tabsSrudent: true,
      tabsTheacer: false,
      btnStatus:true,
      btnStatusTeacher: true
    };
  },
  methods: {
    async getUserLogin() {
      this.getToken();
      await axios
        .get(`/api/user`)
        .then((response) => {
          this.user = response.data;
          this.loginType = response.data.roles[0].name;
          this.schools = response.data.Schools.name.toUpperCase();
        })
        .catch((error) => {
          if (error.response.status === 401) {
            localStorage.clear();
            this.$router.push("/login");
          }
        });
    },
    async getStudent() {
      this.getToken();
      await axios
        .get(`/api/user-by-admin`)
        .then((response) => {
          this.students = response.data.data.getStudent;
        })
        .catch((error) => {
          if (error.response.status === 401) {
            localStorage.clear();
            this.$router.push("/login");
          }
        });
    },
    async getTeacher() {
      this.getToken();
      await axios
        .get(`/api/user-by-admin`)
        .then((response) => {
          this.teachers = response.data.data.getTeacher;
        })
        .catch((error) => {
          if (error.response.status === 401) {
            localStorage.clear();
            this.$router.push("/login");
          }
        });
    },
    submitForm() {
      axios
        .post("/api/create/student", this.form)
        .then((res) => {
          this.error = null;
          this.getStudent();
          this.message = res.data.message;
          setTimeout(() => {
            this.message = false;
          }, 2500);
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          setTimeout(() => {
            this.errors = null;
          }, 2500);
        });
    },
    submitFormTeacher() {
      axios
        .post("/api/create/teacher", this.formTeacher)
        .then((res) => {
          this.error = null;
          this.getTeacher();
          this.messageTeacher = res.data.message;
          setTimeout(() => {
            this.messageTeacher = false;
          }, 2500);
        })
        .catch((error) => {
          this.errorsTeacer = error.response.data.errors;
          setTimeout(() => {
            this.errorsTeacer = null;
          }, 2500);
        });
    },
    getToken() {
      axios.defaults.headers.common["Content-Type"] = "application/json";
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + localStorage.getItem("token");
    },
    handleDelete(id, type) {
      if (type === "STUDENT") {
        let check = confirm("Are you sure delete this student ?");
        if (check) {
          this.getToken();
          axios
            .delete(`/api/delete-student/${id}`)
            .then((res) => {
              this.getStudent();
              this.message = res.data.message;
            })
            .catch((error) => {
              console.log(error);
            });
        }
      } else {
        let check = confirm("Are you sure delete this teacher ?");
        if (check) {
          this.getToken();
          axios
            .delete(`/api/delete-teacher/${id}`)
            .then((res) => {
              this.getTeacher();
              this.messageTeacher = res.data.message;
            })
            .catch((error) => {
              console.log(error);
            });
        }
      }
    },
    handleUpdate(rows, type) {
      if (type === "STUDENT") {
        this.form.name = rows.student;
        this.form.email = rows.email;
        this.form.id = rows.id;
        this.btnStatus = false;
      }else{
        this.formTeacher.name = rows.teacher;
        this.formTeacher.email = rows.email;
        this.formTeacher.id = rows.id;
        this.btnStatusTeacher = false
      }
    },
    handleTabs(id) {
      if (id === "student") {
        this.tabsSrudent = true;
        this.tabsTheacer = false;
      } else {
        this.tabsSrudent = false;
        this.tabsTheacer = true;
      }
    },
    handleInvite(rows, type) {
      let check = confirm("Invite Access Login");
      if (check) {
        this.getToken();
        axios
          .get(`/api/email/${rows.id}/${type}`)
          .then((res) => {
            this.getStudent();
            alert(res.data.message)
          })
          .catch((error) => {
            this.errors = error.response.data.errors;
            setTimeout(() => {
              this.errors = null;
            }, 2500);
          });
      }
    },
    handleCancelForm(){
        this.btnStatusTeacher = true
        this.btnStatus = true;
        this.resetForm()
    },
    resetForm(){
        this.form.name = '';
        this.form.email = '';
        this.formTeacher.name = '';
        this.formTeacher.email = '';
    }
  },
  created() {
    document.title = "Admin Schools";
    this.getUserLogin();
    this.getStudent();
    this.getTeacher();
  },
};
</script>
<style scoped>
.badge {
  cursor: pointer;
}
</style>