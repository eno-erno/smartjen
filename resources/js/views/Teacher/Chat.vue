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
    <div class="row">
        <div class="col-12 col-sm-5 mx-sm-auto mt-5">
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
            <button class="btn btn-warning my-3" @click="handleCancle">Back To Pages Teacher</button>
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
      handleCancle(){
          this.$router.push('/teacher')
      }
    },
    created() {
      document.title = "Chat Student";
      this.getUserLogin();
      this.getStudent();
      this.getTeacher();
    },
}
</script>
<style scoped>
.wrapChat{height: 350px; overflow: auto;}
</style>