export default ({ next, store }) => {
    if(!store.getters['auth/isLogged'] && store.getters['auth/token']) {        
        store.dispatch('auth/fetchUser');
        return next();
    } else if (store.getters['auth/isLogged'] && store.getters['auth/token']) {
        return next();
    }
    else return next({ name : "Login" });
}