import Vue from 'vue';
import Vuetify from 'vuetify';

//css
import './css/deelnemer.css';
import './css/bootstrap.min.css';
import './css/jquery-ui-timepicker-addon.css';
import './css/jquery-ui.css';
import Bezoekernav from './js/layouts/Bezoekernav.vue';

//images

const imagesContext = require.context('./img', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

import Routes from './js/routes.js';

import App from './js/views/App';

Vue.use(Vuetify);
Vue.prototype.$user = null;

Vue.component('nav-bar', {
    template: './js/layouts/Bezoekernav.vue',
});

const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
    router: Routes,
    components: { Bezoekernav },
    render: h => h(App),
});

export default app;