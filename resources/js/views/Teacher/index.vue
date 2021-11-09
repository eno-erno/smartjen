<template>
  <div class="container mt-5">
    <div class="row align-items-md-stretch">
      <div class="col-md-12">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h1>Dashboard, Teacher. <strong>{{schools}}</strong></h1>
          <h6>Welcome {{teacherName}}</h6>
        </div>
      </div>
    </div>
    
    <div class="mt-3">
      <button class="btn btn-sm btn-dark" @click="handleTabs('student')">Student</button>
      <button class="btn btn-sm btn-dark" @click="handleTabs('teacher')">Teacher</button>
    </div>
    <div class="row" v-if="tabsSrudent">
      <div class="col-12 col-sm-6">
        <h2>Student <strong>{{schools}}</strong></h2>
        <table class="table">
          <thead>
            <tr>
              <th style="width:10%">No</th>
              <th>Name Student</th>
              <th style="width:10%">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(rows, index) in students" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ rows.student }}</td>
              <td>
                <button
                  class="btn btn-info btn-sm"
                  @click="handleChat(rows.id, 'STUDENT')"
                >
                  Chat
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row" v-if="tabsTheacer">
      <div class="col-12 col-sm-6">
        <h2>Teacher <strong>{{schools}}</strong></h2>
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Name</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(rows, index) in teachers" :key="rows.id">
              <td>{{ index + 1 }}</td>
              <td>{{ rows.teacher }}</td>
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
        user: '',
        schools: "",
        loginType: '',
        tabsSrudent:true,
        tabsTheacer:false,
        students: [],
        teachers: [],
        teacherName: ''
      }
    },
    methods: {
      async getUserLogin() {
        this.getToken();
        await axios
          .get(`/api/user`)
          .then((response) => {
            this.user = response.data;
            this.loginType = response.data.roles[0].name;
            this.schools = response.data.Schools.name;
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
            this.teacherName = response.data.data.teacher.teacher.toUpperCase()
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
      handleTabs(id){
        if(id === 'student'){
          this.tabsSrudent = true
          this.tabsTheacer = false
        }else{
          this.tabsSrudent = false
          this.tabsTheacer = true
        }
      },
      handleChat(){
        this.$router.push('/teacher/chat')
      }
    },
    created() {
      document.title = "Teacher";
      this.getUserLogin();
      this.getStudent();
      this.getTeacher();
    },
}
</script>