import Vue from 'vue';
import router from './router';
import App from './components/App';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret, faTrashAlt, faEdit } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import swal from 'sweetalert';
import FlashMessage from '@smartweb/vue-flash-message';


window.Vue = require('vue');
window.Bus = new Vue();

library.add(
    faUserSecret, 
    faTrashAlt,
    faEdit)

Vue.component('font-awesome-icon', FontAwesomeIcon)
const config = {
	name: 'flashMessage',
	tag: 'FlashMessage',
	time: 8000
};
Vue.use(FlashMessage, config);



require('./bootstrap');


const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router,
});
