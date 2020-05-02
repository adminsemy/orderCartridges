import axios from 'axios';

export default {
    all() {
        return axios.get('/api/printers');
    },
    find(id) {
        return axios.get(`/api/printers/${id}`);
    },
    update(id, data) {
        return axios.put(`/api/users/${id}`, data);
    },
};