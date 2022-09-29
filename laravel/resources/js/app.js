// Setup global libraries and config
window._ = require('lodash');
window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
require('bootstrap');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';



// Import Vue and plugins
import Vue from 'vue';

import VueTour from 'vue-tour';
// import AuthPlugin from './plugins/auth';

// Install plugins
Vue.use(VueTour);


import './components';
import './directives';

import App from './views/app.vue';
import router from './router';
import store from './store';

// Vue app
const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
});


// Auto dismiss alerts
$('div.alert').not('.alert-important').delay(4000).fadeOut(350);
