/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window._ = require('lodash');
require('./bootstrap');
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

window.Vue = require('vue').default;
window.Event = new Vue();
window.moment = require('moment');
const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674'
}


Vue.use(VueSweetalert2, options)



//ikonice
import Eye from 'vue-material-design-icons/Eye.vue';
import CardsHeart from 'vue-material-design-icons/CardsHeart.vue';
import Star from 'vue-material-design-icons/Star.vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
if (document.querySelector("meta[name='user_id']")) {
    Vue.prototype.$userId = document.querySelector("meta[name='user_id']").getAttribute('content');
    Vue.prototype.$userId = JSON.parse(Vue.prototype.$userId);

} else Vue.prototype.$userId = null;

if (document.querySelector("meta[name='userHasPermission']")) {
    Vue.prototype.$userPermissions = document.querySelector("meta[name='userHasPermission']").getAttribute('content');

    // Check if auth user has specific permission
    Vue.prototype.$userHasPermission = function(permission) {
        return _.includes(this.$userPermissions, permission);
    }
} else {
    Vue.prototype.$userHasPermission = [];
}

Vue.component('navbar-component', require('./components/Navigation.vue').default);
Vue.component('Spinner', require('./components/delovi/SpinnerComponent.vue').default);
Vue.component('footer-component', require('./components/delovi/Footer.vue').default);



Vue.component('eye-icon', Eye);
Vue.component('heart-icon', CardsHeart);
Vue.component('star-icon', Star);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VModal from 'vue-js-modal'
import router from './router'
import { info } from 'daisyui/colors/colorNames';

Vue.use(VModal, { dynamic: true, injectModalsContainer: true })

const app = new Vue({
    el: '#app',
    router: router
});
