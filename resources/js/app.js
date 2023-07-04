/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import router from './router/index';
import { ValidationProvider, ValidationObserver } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import { extend } from 'vee-validate';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Datatable from 'vue2-datatable-component'
import $ from 'jquery';
import 'bootstrap';

extend('required', {
    ...rules.required,
    message: '{_field_} is required'
});

const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
};

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueSweetalert2);
Vue.use(Datatable)


Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

window.$ = window.jQuery = $;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});