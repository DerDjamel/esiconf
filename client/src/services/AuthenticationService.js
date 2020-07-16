import api from './api';


const endpoints = {
    login   : '/auth/login',
    logout  : '/auth/logout',
    refresh : '/auth/refresh',
    user    : '/auth/me'
}

export default {
    login(credentials){
        return api.post(endpoints.login, credentials);
    },

    logout(){
        return api.post(endpoints.logout);
    },

    user(){
        return api.post(endpoints.user);
    },
}