import Vue from 'vue';
import router from './router';
import App from './components/App';
//import vuetron from 'vuetron'

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
