import api from './api';


export default {
    show(id){
        return api.get(`/paper/${id}`);
    },

    store(info){
        return api.post(`/paper/`, info);
    },

    user_papers(){
        return api.get(`/user/paper`);
    },
}