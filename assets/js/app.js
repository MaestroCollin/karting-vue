import Vue from 'vue';
import Vuetify from 'vuetify';

import Routes from './routes.js';

import App from './views/App';
const imagesContext = require.context('../img', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);
Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App),
});

export default app;