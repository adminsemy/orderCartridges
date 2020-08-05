import axios from 'axios';

export default {
    all() {
        return axios.get('/api/admin/brands');
    },
    name() {
        return axios.get('/api/admin/brands/name');
    },
    new(data) {
        return axios.put('/api/admin/brands/new', data);
    },
    edit(id, data) {
        return axios.post(`/api/admin/create/brands/${id}`, data);
    },
    delete(id) {
        return axios.delete(`/api/admin/delete/brands/${id}`);
    }
};