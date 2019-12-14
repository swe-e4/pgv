import Vue from 'vue';
import VueRouter from 'vue-router';
import Overview from './views/Overview';
import AdviserCreate from './views/AdviserCreate';
import Disabled from './views/Disabled';

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: Overview},
        { path: '/adviser/create', component: AdviserCreate},
        { path: '/disabled', component: Disabled}
    ],
    mode: 'history'
});