window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from "laravel-echo";
window.Pusher =  require("pusher-js");

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '1362eaa5496d5f8116b2',
    cluster: 'ap3',
    encrypted: true
});

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
  
    require('bootstrap');
  } catch (e) {}