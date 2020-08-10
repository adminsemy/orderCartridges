import axios from 'axios';

export default {
    all() {
        return axios.get('/api/admin/cartridges');
    },
    name() {
        return axios.get('/api/admin/cartridges/name');
    },
    new(data) {
        return axios.post('/api/admin/cartridges/new', data);
    },
    edit(id, data) {
        return axios.put(`/api/admin/cartridges/${id}/edit`, data);
    },
    delete(id) {
        return axios.delete(`/api/admin/cartridges/${id}/delete`);
    }
};