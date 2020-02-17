import Vue from 'vue'
import VueRouter from 'vue-router'
// import axios from 'axios'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    auth: false,
    base: '/snack',
    routes: [{
            path: '/snack/dashboard',
            name: 'Dashboard',
            component: require('./components/DashboardComponent.vue'),
        },
        {
            path: '/dashboard1',
            name: 'Dashboard1',
            component: require('./components/DashboardComponent1.vue'),
        },
    ]
});

export default router
