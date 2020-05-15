import Admin from '../components/admin/Admin'
import Orders from '../components/admin/Orders'

export default [
    { 
        path: '/admin',
        name: 'admin',
        component: Admin,
        children: [
            {
                path: 'orders',
                name: 'admin.orders',
                component: Orders
            }
        ]
    }
]