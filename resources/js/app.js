require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './components/App.vue';
Vue.use(VueRouter)
import routes from './router';
const router = new VueRouter(routes);
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    let token = localStorage.getItem('token') != null;
    if (!token) {
      next({
        path: '/login',
        query: {
          redirect: to.fullPath
        }
      })
    } else {
      let user = JSON.parse(localStorage.getItem('user'))
      let roles = user.roles.map(role => role.name)
      if (to.matched.some(record => record.meta.isStudent)) {
        if (roles.includes('STUDENT')) next()
        // else if (roles[0] === 'ADMIN') {
        //   next({
        //     name: 'admin'
        //   })
        // } else if (roles[0] === 'TEACHER') {
        //   next({
        //     name: 'teacher'
        //   })
        // } 
        else next({
          name: 'home'
        })
      } else if (to.matched.some(record => record.meta.isAdmin)) {
        if (roles.includes('ADMIN')) next()
        // else if (roles[0] === 'TEACHER') {
        //   next({
        //     name: 'teacher'
        //   })
        // } else if (roles[0] === 'STUDENT') {
        //   next({
        //     name: 'student'
        //   })
        // } 
        else next({
          name: 'admin'
        })

      } else if (to.matched.some(record => record.meta.isTeacher)) {
        if (roles.includes('TEACHER')) next()
        // else if (roles[0] === 'STUDENT') {
        //   next({
        //     name: 'student'
        //   })
        // } 
        // else if (roles[0] === 'ADMIN') {
        //   next({
        //     name: 'admin'
        //   })
        // } 
        else next({
          name: 'teacher'
        })

      } else {
        next()
      }
    }
  } else {
    next()
  }
})
new Vue({
  el: '#app',
  components: { App },
  router: router,
});