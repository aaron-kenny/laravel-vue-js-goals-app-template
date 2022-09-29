import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from '../views/home.vue';
import GoalsView from '../views/goals-view.vue';
import AccountView from '../views/account-view.vue';
import BillingView from '../views/billing-view.vue';
import NotFound from '../views/not-found.vue';
import store from '../store';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/goals',
            name: 'goals',
            component: GoalsView
        },
        {
            path: '/account',
            name: 'account',
            component: AccountView
        },
        {
            path: '/account/billing',
            name: 'billing',
            component: BillingView
        },
        {
            path: '*',
            name: '404',
            component: NotFound
        }
    ]
})

// router.beforeEach((to, from, next) => {
//     // Check for auth token
//     // if(store.getters['auth/hasPermission']) {
//     // if(false) {
//     //     next();
//     // } else {
//     //     let continueUrl = encodeURIComponent('https://local-accounts.laravelwebsite.com' + to.fullPath);
//     //     window.location = 'https://local-accounts.laravelwebsite.com/login?continue=' + continueUrl + '&service=Product_Three';
//     // }
// });

export default router;
