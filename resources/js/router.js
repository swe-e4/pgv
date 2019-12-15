import Vue from 'vue';
import VueRouter from 'vue-router';
import Overview from './views/Overview';

import Adviser from './views/Adviser';
import AdviserCreate from './views/AdviserCreate';
import AdviserEdit from './views/AdviserEdit';

import Group from './views/Group';
import GroupCreate from './views/GroupCreate';
import GroupEdit from './views/GroupEdit';

import Disabled from './views/Disabled';

import Logout from './actions/Logout';

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/', component: Overview,
            meta: {title: 'Übersicht' }
        },

        {
            path: '/adviser', component: Adviser,
            meta: {title: 'Betreuer' }
        },
        {
            path: '/adviser/create', component: AdviserCreate,
            meta: {title: 'Betreuer hinzufügen' }
        },
        {
            path: '/adviser/:id/edit', component: AdviserEdit,
            meta: {title: 'Betreuer bearbeiten' }
        },
        
        {
            path: '/group', component: Group,
            meta: {title: 'Gruppen' }
        },
        {
            path: '/group/create', component: GroupCreate,
            meta: {title: 'Gruppen hinzufügen' }
        },
        {
            path: '/group/:id/edit', component: GroupEdit,
            meta: {title: 'Gruppen bearbeiten' }
        },

        {
            path: '/disabled', component: Disabled,
            meta: {title: 'Deaktiviert' }
        },

        {
            path: '/logout', component: Logout
        }
    ],
    mode: 'history'
});