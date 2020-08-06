import axios from 'axios';
import Cookies from 'js-cookie';


const api = axios.create({
    baseURL : "http://127.0.0.1:8000/api",
});

api.defaults.headers.common['Authorization']    =  'bearer ' + Cookies.get('access_token') || null;
api.defaults.headers.common['Accept']           = 'application/json';
api.defaults.headers.post['Content-Type']       = 'application/x-www-form-urlencoded';
api.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default api;

