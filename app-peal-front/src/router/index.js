import { createRouter, createWebHistory } from 'vue-router'
import authMiddleware from '../middleware/auth';
import authUserMiddleware from '../middleware/authUser';
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Employee from '../components/Layouts/Employee.vue'
import AdminEmployee from '../components/Layouts/AdminEmployee.vue'
import Dashbord from '../views/Dashbord.vue'
import UserLayout from '../components/Layouts/UserLayout.vue'
import Appeal from '../views/Appeal.vue'
import CheckStatusAppeal from '../views/CheckStatusAppeal.vue'
import UserView from '../views/UserView.vue'
//Employee
/* import EmAppeal from '../views/EmAppeal.vue' */
import CheckEmployee from '../middleware/CheckEmployee';
import CheckDepEmployee from '../middleware/CheckDepEmployee';
import EmDb from '../views/Em/EmDashbord.vue'
import EmAppeal from '../views/Em/EmCheckStatusAppeal.vue'
import EmViewAppeal from '../views/Em/EmViewAppeal.vue'

//AdminEmployee
import AdminDb from '../views/AdminEm/AdminDashbord.vue'
import AdminEmAppeal from '../views/AdminEm/AdminEmCheckstatusAppeal.vue'
import AdminEmViewAppeal from '../views/AdminEm/AdminViewAppeal.vue'
import CheckAdminEmployee from '../middleware/CheckAdminEmployee';


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/sendpassreset',
    component: () => import('../views/SendResetPassword.vue')
  },
  {
    path: '/user/reset/:token',
    component: () => import('../views/ResetPassword.vue')
  },

  /* {
    path: '/employee',
    redirect: { name: 'Dashbord' } // เปลี่ยนเส้นทางไปยัง Dashbord
  }, */

  {
    path: '/user',
    name: 'User',
    component: UserLayout,
    redirect: { name: 'Appeal' },
 
    children: [
      {
        path: 'appeal',
        name: 'Appeal',
        component: Appeal,
      },
      {
        path: 'CheckStatusAppeal',
        name: 'CheckStatusAppeal',
        component: CheckStatusAppeal,
      },
      {
        path: '/user/CheckStatusAppeal/view=:app_doc',
        name: 'UserView',
        component: UserView,
      },
    ]

  },

  {
    path: '/AdminEmployee',
    redirect: { name: 'AdminDashbord' },
    name: 'AdminEmployee',
    component: AdminEmployee,

    meta: {
      middleware: [CheckAdminEmployee] // Use the authMiddleware for this route
    },
    children: [
      {
        path: 'dashbord',
        name: 'AdminDashbord',
        component: AdminDb,
      },
      {
        path: 'CheckStatusAppeal',
        name: 'AdminEmAppeal',
        component: AdminEmAppeal,
        
      },
      {
        path: '/AdminEmployee/CheckStatusAppeal/view=:app_id',
        name: 'AdminEmViewAppeal',
        component: AdminEmViewAppeal,
      },
    ]
  },

  {
    path: '/employee',
    name: 'Employee',
    component: Employee,
    meta: {
      middleware: [CheckEmployee] // Use the authMiddleware for this route
    },
    children: [
      {
        path: 'dashbord',
        name: 'EmDashboed',
        component: EmDb,
      },
      {
        path: 'CheckStatusAppeal',
        name: 'EmAppeal',
        component: EmAppeal,
      },
      {
        path: '/Employee/CheckStatusAppeal/view=:app_id',
        name: 'EmViewAppeal',
        component: EmViewAppeal,
        meta: {
          middleware: [CheckDepEmployee] // เพิ่ม middleware ที่ต้องการให้ทำงานกับเส้นทางนี้
        }
      },
    ]
  },

 /*  {
    path: '/user',
    name: 'User',
    component: UserLayout,
    redirect: { name: 'Appeal' },
    meta: {
      middleware: [authUserMiddleware] // Use the authMiddleware for this route
    },
    children: [
      {
        path: 'appeal',
        name: 'Appeal',
        component: Appeal,
      },
      {
        path: 'CheckStatusAppeal',
        name: 'CheckStatusAppeal',
        component: CheckStatusAppeal,
      },
      {
        path: '/user/CheckStatusAppeal/view=:app_doc',
        name: 'UserView',
        component: UserView,
      },
    ]

  } */


]

const router = createRouter({
  history: createWebHistory(),
  routes
})
router.beforeEach((to, from, next) => {
  // Call middleware for each route
  if (to.meta.middleware) {
    to.meta.middleware.forEach(middleware => {
      middleware(to, from, next);
    });
  } else {
    next();
  }
});


export default router