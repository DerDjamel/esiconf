import api from './api';


export default {
    user_bids(){
        return api.get(`/user/bids`);
    },
}