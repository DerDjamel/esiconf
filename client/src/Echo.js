import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Cookies from 'js-cookie';

window.Pusher = Pusher;
Pusher.log = function (message) { window.console.log(message); }

const laravel_echo = new Echo({
  broadcaster: 'pusher',
  key: 'd1b801ab47517e6bf62d',
  cluster: 'eu',
  encrypted: true,
  authEndpoint: 'http://127.0.0.1:8000/broadcasting/auth',
  auth: {
    headers: {
       Authorization: 'bearer ' + Cookies.get('access_token') || null
    }
 },
});

export default laravel_echo;