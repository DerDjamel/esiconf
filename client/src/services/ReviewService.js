import api from './api';


export default {
    show(id){
        return api.get(`/review/${id}`);
    },
    store(id, info){
        return api.post(`/review/paper/${id}`, info);
    },
}