import AuthenticationService from '@/services/AuthenticationService';
import Cookies from "js-cookie";

const state = {
    user        : null,
    token       : Cookies.get('token') || null,
    error       : null,
    loading     : false,
    isLogged    : false
};

const getters = {
    user        : state => state.user,
    token       : state => state.token,
    isLogged    : state => state.isLogged,
    error       : state => state.error,
    isLoading   : state => state.loading
};

const mutations = {
    isLoggingIn(state){
        state.loading   = true;
        state.error     = null;
        state.isLogged  = false;
    },
    
    loginSuccess(state, { access_token }){
        state.loading   = false;
        state.error     = null;
        state.token     = access_token;
        state.isLogged  = true;

        Cookies.set("token", access_token);
    },

    loginFailure(state, { error }){
        state.loading   = false;
        state.error     = error;
        state.isLogged  = false;
    },

    fetchUserSuccess(state, user) {
        console.log("user ==> :" + user);
        state.user = user;
        state.isLogged = true;
        state.loading   = false;
    },

    ferchUserFailure(state) {
        state.token = null;
        Cookies.remove("token");
        state.isLogged = false;
    },

    logout(state) {
        state.user      = null;
        state.token     = null;
        state.isLogged = false;
        Cookies.remove("token");
    }
};

const actions = {
    isLoggingIn({ commit }){
        commit('isLoggingIn');
    },

    loginSuccess({ commit }, data){
        commit('loginSuccess', data);
    },

    loginFailure({ commit }, data){
        commit('loginFailure', data);
    },

    logout({ commit }){
        commit('logout');
    },

    async fetchUser({ commit }){
        try {
            const { data } = await AuthenticationService.user();
            commit('fetchUserSuccess', data);
        } catch (error) {
            commit('ferchUserFailure');
        }
    },
};


export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}