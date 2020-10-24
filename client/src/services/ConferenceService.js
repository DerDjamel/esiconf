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

    delete(conference_slug){
        return api.delete(`/conference/${conference_slug}`);
    },

    reviews(slug){
        return api.get(`/conference/${slug}/reviews`);
    },

    reviewers(slug){
        return api.get(`/conference/${slug}/reviewers`);
    },

    conferences_reviewers(slug){
        return api.get(`/reviewers/conference/${slug}`);
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

    add_reviewer(slug, email){
        return api.post(`/conference/${slug}/reviewer`, email);
    },

    remove_reviewers(slug, reviewers){
        return api.post(`/reviewers/conference/${slug}`, reviewers);
    }

}