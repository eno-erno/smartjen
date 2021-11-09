<template>
  <div class="container mt-5">
    <div class="row align-items-md-stretch">
      <div class="col-md-12">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h1>Dashboard, Student <strong>{{schools}}</strong></h1>
        </div>
      </div>
    </div>
    
    <div class="mt-3">
      <button class="btn btn-sm btn-dark" @click="handleTabs('student')">Student</button>
      <button class="btn btn-sm btn-dark" @click="handleTabs('teacher')">Teacher</button>
    </div>
    <div class="row">
      <div class="col-12 col-sm-6">
        <div class="row" v-if="tabsSrudent">
          <div class="col-12">
            <h2 class="bg-white shadow mt-3 p-3">Student</h2>
            <table class="table mt-5">
              <thead>
                <tr>
                  <th style="width:10%">No</th>
                  <th>Name Student</th>
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
        </div>
        <div class="row" v-if="tabsTheacer">
          <div class="col-12">
            <h2 class="bg-white shadow mt-3 p-3">Teacher</h2>
            <table class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name Teacher</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(rows, index) in teachers" :key="rows.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ rows.teacher }}</td>
                  <td>
                    <button
                      class="btn btn-info btn-sm"
                      @click="handleChat(rows)"
                    >
                      Chat
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6" v-if="showChat">
        <div class="row">
          <div class="col-12  mx-sm-auto mt-5">
              <div class="card">
                  <div class="card-header">
                      Chat Room to Teacher <strong>{{nameUser}}</strong>
                  </div>
                  <div class="card-contant">
                      <div class="wrapChat py-4">
                          <div class="row" v-for="(rows, index) in messageAllFrom" :key="index">
                              <div class="col-12 text-start mb-3 ">
                                  <div class="chatting px-2 w-50 text-white p-3 rounded" :class="{'text-end' : rows.user_from_id === chatUser.id, 'ms-auto' : rows.user_from_id === chatUser.id, 'bg-secondary' : rows.user_from_id === chatUser.id,'bg-info' : rows.user_from_id !== chatUser.id}">
                                      {{rows.message}}
                                  </div>
                              </div>
                              <!-- <div class="col-12 mb-3" v-if="rows.user_from_id === nameUserid">
                                  <div class="chatting px-2 w-50 text-end ms-auto bg-secondary p-3 text-white rounded">
                                      {{rows.message}}
                                  </div>
                              </div> -->
                          </div>
                      </div>
                  </div>
                  <div class="card-contant pt-4">
                      <!-- <form action=""> -->
                            <div class="d-flex">
                                <textarea name="" rows="1" class="form-control me-2" placeholder="Input Message" v-model="message"></textarea>
                                <button class="btn btn-primary" @click="sendMessage()">Send</button>
                            </div>
                      <!-- </form> -->
                  </div>
              </div>
              <button class="btn btn-warning my-3" @click="handleCancle">Cancel</button>
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
        user: '',
        schools: "",
        loginType: '',
        tabsSrudent:true,
        tabsTheacer:false,
        students: [],
        teachers: [],
        teacherName: '',
        teacherId: '',
        showChat:false,
        nameUser: '',
        nameUserid: '',
        chatUser : {},
        message: '',
        messageAllFrom: []
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
            this.teacherName = response.data.data.teacher.teacher.toUpperCase()
            this.teacherId = response.data.data.teacher.users_id
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
      handleChat(rows){
        this.showChat = true
        this.nameUser = rows.teacher.toUpperCase();
        this.nameUserid = rows.id;
        this.chatUser = rows;
        this.getMessage(rows.id);
      },
      handleCancle(){
        this.showChat = false
      },
      getMessage(id){
        axios.get(`/api/messages/${id}`)
          .then(res => {
            this.messageAllFrom = res.data.data;
            console.log(this.messageAllFrom)
            // res.data.data.map(element => {
            //   if(element.user_from_id === this.teacherId){
            //     console.log('asu')
            //     this.messageAllFrom.push(element)
            //   }
            // });
            // console.log('kentu',this.messageAllFrom)
          })
          .catch(err => {
            console.log(err);
          })
      },
      sendMessage(){
        axios.post(`/api/messages/${this.chatUser.id}`, {
          'message' : this.message
        }).then(response => {
          console.log(response.data);
        });
      },
    },
    created() {
      document.title = "Student";
      this.getUserLogin();
      this.getStudent();
      this.getTeacher();
      this.getMessage(this.nameUserid);
      setInterval(() => {
        if(this.chatUser.id){
          this.getMessage(this.chatUser.id);
        }
      }, 1000);
    }
}
</script>
<style scoped>
.wrapChat{height: 350px; overflow: auto;}
</style>