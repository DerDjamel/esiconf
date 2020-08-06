import Cookies from "js-cookie";

export default ({ next, store }) => {
    if(Cookies.get('access_token') && !store.getters['auth/isLogged']) {        
        store.dispatch('auth/fetchUser');
        return next();
    } else if (store.getters['auth/isLogged'] && store.getters['auth/token']) {
        return next();
    }
    else return next({ name : "Login" });
}