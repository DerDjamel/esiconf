import api from './api';


export default {
    show(id){
        return api.get(`/review/${id}`);
    },
}