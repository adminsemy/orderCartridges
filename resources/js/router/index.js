import Vue from 'vue'
import Router from 'vue-router'
import Home from '../components/Home'
import UserIndex from '../components/UserIndex'
import UserEdit from '../components/UserEdit'
import NotFound from '../components/NotFound'
import Printers from '../components/Printers'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/users',
      name: 'users.index',
      component: UserIndex,
    },
    {
      path: '/users/:id/edit',
      name: 'users.edit',
      component: UserEdit,
    },
    { 
      path: '/home',
      name: 'home',
      component: Home,
    },
    { 
      path: '/printers',
      name: 'printers',
      component: Printers,
    },
    {
      path: '/',
      name: 'general',
    },
    {
      path: '/404',
      name: '404',
      component: NotFound
    },
    {
      path: '*',
      redirect: '/404'
    },

  ]
})
