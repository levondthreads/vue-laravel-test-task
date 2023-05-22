import Vue from 'vue';
import App from './App.vue'

import PrimeVue from 'primevue/config';
import Dialog from 'primevue/dialog';
import Datatable from 'primevue/datatable';

Vue.use(PrimeVue);
Vue.component('Datatable', Datatable);
Vue.component('Dialog', Dialog);

require('./bootstrap');

// import 'primevue/resources/themes/saga-blue/theme.css'
// import 'primevue/resources/primevue.min.css'
// import 'primeicons/primeicons.css'



const app = new Vue({
    el: '#app',
    components: {
        App
    },
});
