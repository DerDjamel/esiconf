import api from './api';


export default {
    show(slug){
        return api.get(`/conference/${slug}`);
    },

    create(info){
        return api.post(`/conference/`, info);
    },

    update(info){
        return api.put(`/conference/${info.slug}`, info);
    },

    reviews(slug){
        return api.get(`/conference/${slug}/reviews`);
    },

    reviewers(slug){
        return api.get(`/conference/${slug}/reviewers`);
    },

    papers(slug){
        return api.get(`/conference/${slug}/papers`);
    },

    bids(slug){
        return api.get(`/conference/${slug}/bids`);
    },

    user_conferences(){
        return api.get(`/user/conferences`);
    },

}