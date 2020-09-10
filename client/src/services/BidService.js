import api from './api';


export default {
    user_bids(){
        return api.get(`/user/bids`);
    },

    store(paper_id, bid){
        return api.post(`/bid/${paper_id}`, bid);
    },
}