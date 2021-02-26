/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';

import Swal from 'sweetalert2';

Vue.component('pagination', require('laravel-vue-pagination'));


Vue.use(VueAxios, axios, VueRouter);
Vue.use(VueRouter);

Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
});


window.Fire = new Vue();
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  window.Toast = Toast;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

let routes = [
    { path: '/dashboard', component: require('./components/dashboard.vue').default },
    { path: '/company', component: require('./components/Company.vue').default },
    { path: '/employee', component: require('./components/Employee.vue').default },
    { path: '/profile/change-password', component: require('./components/change-password.vue').default },
    { path: '/profile', component: require('./components/dashboard.vue').default },

    { path: '/*', component: require('./components/dashboard.vue').default },
];


const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});


const app = new Vue({
    el: '#app',
    router,
	data(){
		return {
		   name: 'Majeed Opeyemi' 
		}
	}
});