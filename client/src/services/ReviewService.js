import api from './api';


export default {
    show(id){
        return api.get(`/review/${id}`);
    },
    store(id, info){
        return api.post(`/review/paper/${id}`, info);
    },
    user_reviews(){
        return api.get(`/user/reviews`);
    },
}