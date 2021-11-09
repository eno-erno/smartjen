import Home from '../views/Home';
import Login from '../views/Login';
import Register from '../views/Register';
import Student from '../views/Student';
import Admin from '../views/Admin';
import Teacher from '../views/Teacher';
import Chat from '../views/Teacher/Chat';

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },   
        {
            path: '/student',
            name: 'student',
            component: Student,
            meta: {
                requiresAuth: true,
                isStudent: true
              }
        },
        {
            path: '/admin',
            name: 'admin',
            component: Admin ,
            meta: {
                requiresAuth: true,
                isAdmin: true
             }
        }, 
        {
            path: '/teacher',
            name: 'teacher',
            component: Teacher,
            meta: {
                requiresAuth: true,
                isTeacher: true
             }
        },
        {
            path: '/teacher/chat',
            name: 'chat',
            component: Chat,
            meta: {
                requiresAuth: true,
                isTeacher: true
             }
        } 
    ],
}