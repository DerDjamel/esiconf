import api from './api';


export default {
    show(id){
        return api.get(`/review/${id}`);
    },
    store(id, info){
        return api.post(`/review/paper/${id}`, info);
    },
    update(review, info){
        return api.put(`/review/${review.id}/paper/${review.paper_id}`, info);
    },
    user_reviews(){
        return api.get(`/user/reviews`);
    },
    delete(id){
        return api.delete(`/review/${id}`);
    }
}