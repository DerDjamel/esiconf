import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
Pusher.log = function (message) { window.console.log(message); }

const laravel_echo = new Echo({
  broadcaster: 'pusher',
  key: 'd1b801ab47517e6bf62d',
  cluster: 'eu',
  encrypted: true
});

export default laravel_echo;