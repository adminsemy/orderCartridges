import axios from 'axios';

export default {
    all() {
        return axios.get('/api/admin/brands');
    },
    name() {
        return axios.get('/api/admin/brands/name');
    },
    new(data) {
        return axios.post('/api/admin/brand/new', data);
    },
    edit(id, data) {
        return axios.put(`/api/admin/brand/${id}/edit`, data);
    },
    delete(id) {
        return axios.delete(`/api/admin/brand/${id}/delete`);
    }
};