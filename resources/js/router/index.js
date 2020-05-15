import Vue from 'vue'
import Router from 'vue-router'
import Home from '../components/Home'
import UserIndex from '../components/UserIndex'
import UserEdit from '../components/UserEdit'
import NotFound from '../components/NotFound'
import Printers from '../components/Printers'
import OrderCartridge from '../components/OrderCartridge'
import Admin from './admin'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    ...Admin,
    { 
      path: '/printers',
      name: 'printers',
      component: Printers,
    },
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
      path: '/printer/:id/order',
      name: 'order.cartridge',
      component: OrderCartridge,
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
