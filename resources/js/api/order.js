import axios from 'axios';

export default {
    findPrinter(id) {
        return axios.get(`/api/printer/${id}/order`);
    },
    update(printer_id, data) {
        return axios.put(`/api/printer/${printer_id}/order`, data);
    },
};