/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import VueRouter from 'vue-router';

// sweetalert2
import Swal from 'sweetalert2';
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
});

window.Toast = Toast;

// vue progressbar

import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '5px'
});

//v-form
import { Form, HasError, AlertError } from 'vform';
window.form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

// end of vfrom



Vue.use(VueRouter);

const linkExactActiveClass = "vue-link-active-class";

const routes = [
    {
     path:'/dashboard',
     name:'dashboard',
     component: require('./components/Dashboard').default
    },
    { 
     path:'/profile',
     name:'dashboard',
     component: require('./components/Profile').default
     },
     { 
      path:'/user',
      name:'user',
      component: require('./components/User').default
      }
  ];


  const router = new VueRouter({
    routes, // short for `routes: routes`
    linkExactActiveClass,
  });

  //Global Filters
  Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
  });

  Vue.filter('dateFormate',function(created){
    return moment(created).format("MMM Do YY"); 
  });

 //GLOBAL Custom Event key replace(this)
 window.Fire= new Vue();
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
