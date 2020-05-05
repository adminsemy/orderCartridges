import axios from 'axios';

export default {
    findPrinter(id) {
        return axios.get(`/api/printer/${id}/order`);
    },
    update(printer_id, cartridge_id, data) {
        return axios.put(`/api/order/printer/${printer_id}/cartridge/${cartridge_id}`, data);
    },
};