import Vue from 'vue';
import router from './router';
import App from './components/App';
import vuetron from 'vuetron'

require('./bootstrap');;

Vue.use(vuetron.VuetronVue);

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});
