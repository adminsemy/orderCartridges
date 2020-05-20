import axios from 'axios';

export default {
    findOrder() {
        return axios.get(`/api/admin/order`);
    },
    findPrinter(id) {
        return axios.get(`/api/printer/${id}/order`);
    },
    update(printer_id, data) {
        return axios.put(`/api/printer/${printer_id}/order`, data);
    },
    giveCartridge(cartridge_id, cartridge) {
        return axios.post(`/api/admin/send/cartridge/order/${cartridge_id}`, { cartridge: cartridge });
    }
};