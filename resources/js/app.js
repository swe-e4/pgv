import Vue from 'vue';
import router from './router';
import App from './components/App';

import Datetime from 'vue-datetime';
//import vuetron from 'vuetron'
Vue.use(Datetime)
require('./bootstrap');

//Vue.use(vuetron.VuetronVue);

productionSourceMap: false
const app = new Vue({
    el: '#app',
    productionSourceMap: false,
    components: {
        App
    },
    router
});
