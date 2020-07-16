export default ({ next, store }) => {
    if(store.getters['auth/token']){
        return next({ name : "Home" })
    } else 
        return next();
}