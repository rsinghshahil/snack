require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import swal from 'sweetalert';

Vue.use(VueRouter);
window.swal = swal;
window.Vue = require('vue');
window.router = router;
Vue.use(VueAxios, axios);


const routes = [
    { path: '/snack/dashboard', component: require('./components/DashboardComponent.vue').default},
    { path: '/dashboard1', component: require('./components/DashboardComponent1.vue').default},

    { path: '/register-user', component: require('./components/user-register/IndexComponent.vue').default},
    { path: '/menu', component: require('./components/menu/MenuComponent.vue').default},
    { path: '/daily-meal', component: require('./components/menu/DailyMealComponent.vue').default},
    { path: '/manage-meal-order', component: require('./components/daily-orders/OrdersComponent.vue').default},
    { path: '/meal-links', component: require('./components/menu/MealLinkComponent.vue').default},
  ];

  const router = new VueRouter({
      mode:'history',
      base:'/snack',
    routes
  })


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
