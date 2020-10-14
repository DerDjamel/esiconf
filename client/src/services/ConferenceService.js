import api from './api';


export default {
    index(){
        return api.get('/conference');
    },
    index_page(page){
        return api.get('/conference?page=' + page);
    },
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