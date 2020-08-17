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

}