import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';

import Home from './components/bezoeker/Home';
import Aanbod from './components/bezoeker/Aanbod';
import Contact from './components/bezoeker/Contact';

import UserIndex from './components/deelnemer/Index';
import UserProfile from './components/deelnemer/Profile';
import UserProfileChange from './components/deelnemer/ProfileChange';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'home', component: Home },
        { path: '/aanbod', name: 'aanbod', component: Aanbod },
        { path: '/contact', name: 'contact', component: Contact },

        { path: '/user/', name: 'userhome', component: UserIndex },
        { path: '/user/profile', name: 'userprofile', component: UserProfile },
        { path: '/user/profile/change', name: 'userprofilechange', component: UserProfileChange },
    ]
});

export default router;

router.beforeEach(async (to, from, next) => {
    if (router.app.$user === null) {
        const response = await axios.get('/api/user')
        Vue.prototype.$user = response.data
            console.log(response.data)
        if (router.app.$user === null) {
           
        }
    }
    next();
})