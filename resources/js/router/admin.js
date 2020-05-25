import Admin from '../components/admin/Admin'
import Orders from '../components/admin/Orders'
import PrintersBrand from '../components/admin/PrintersBrand'
import PrintersList from '../components/admin/PrintersList'
import Cartridges from '../components/admin/Cartridges'

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
            },
            {
                path: 'printers_list',
                name: 'admin.printersList',
                component: PrintersList
            },
            {
                path: 'printers_brand',
                name: 'admin.printersBrand',
                component: PrintersBrand
            },
            {
                path: 'cartridges',
                name: 'admin.cartridges',
                component: Cartridges
            }
        ]
    }
]