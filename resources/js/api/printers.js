import axios from 'axios';

export default {
    all() {
        return axios.get('/api/printers');
    },
    brands() {
        return axios.get('/api/printer_brands');
    },
};