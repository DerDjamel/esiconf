import api from './api';


export default {
    show(id){
        return api.get(`/paper/${id}`);
    },
}