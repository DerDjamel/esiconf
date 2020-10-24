export default ({ next, store }) => {
    if(store.getters['auth/isLogged']) return next();
    else return next({ name : "Login" });
}