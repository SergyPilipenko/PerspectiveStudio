/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuex from 'vuex';
Vue.config.devtools = true;

Vue.use(Vuex);

/**
 * Vuex
 */
import selectCar from './frontend/store/modules/select-car';
import garage from './frontend/store/modules/garage';

Vue.component('select-car', require('./frontend/components/frontpage/SelectCar').default);
Vue.component('select-car-body', require('./frontend/components/categories/SelectCarBody').default);
Vue.component('garage', require('./frontend/components/Garage').default);
Vue.component('product-show', require('./frontend/components/product/Show').default);
Vue.component('cart', require('./frontend/components/cart/Cart').default);

const store = new Vuex.Store({
    modules: {
        selectCar,
        garage,
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.onload = function () {
    const app = new Vue({
        el: '#app',
        store
    });
};
