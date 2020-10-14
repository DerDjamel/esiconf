import api from './api';


const endpoints = {
    login   : '/auth/login',
    register   : '/auth/register',
    logout  : '/auth/logout',
    refresh : '/auth/refresh',
    user    : '/auth/me'
}

export default {
    login(credentials){
        return api.post(endpoints.login, credentials);
    },

    register(credentials){
        return api.post(endpoints.login, credentials);
    },

    logout(){
        return api.post(endpoints.logout);
    },

    user(token){
        return api.post(endpoints.user , {
            headers: {
                Authorization : `bearer ${token}`,
              }
        });
    },
}