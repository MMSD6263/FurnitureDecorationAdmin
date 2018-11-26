import Vue from 'vue';
import VueRooter from 'vue-router';

import Index from '../components/Index';

const routes = [
    {
        path: '/',
        name:'homeLink',
        component:Index
    }
]
Vue.use(VueRooter)

const router = new VueRooter({
    routes
})

export default router
