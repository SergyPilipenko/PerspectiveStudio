/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.lang = document.documentElement.lang;
window.Vue = require('vue');
import Vuex from 'vuex';
Vue.config.devtools = true;

Vue.use(Vuex);

/**
 * Vuex
 */
import selectCar from './frontend/store/modules/select-car';
import garage from './frontend/store/modules/garage';
import productShow from './frontend/store/modules/productShow';
import Cart from './frontend/store/modules/cart';
import Checkout from './frontend/store/modules/checkout';
import Search from './frontend/store/modules/search';

Vue.component('search-button', require('./frontend/components/Search/SearchButton').default);
Vue.component('search-tabs', require('./frontend/components/frontpage/SearchTabs').default);
Vue.component('select-car', require('./frontend/components/frontpage/SelectCar').default);
Vue.component('select-car-body', require('./frontend/components/categories/SelectCarBody').default);
Vue.component('garage', require('./frontend/components/Garage').default);
Vue.component('search', require('./frontend/components/Search/Search').default);
Vue.component('product-show', require('./frontend/components/product/Show').default);
Vue.component('cart', require('./frontend/components/cart/Cart').default);
Vue.component('checkout', require('./frontend/components/checkout/Checkout').default);
Vue.component('checkout-cart', require('./frontend/components/checkout/CheckoutCart').default);
Vue.component('checkout-user-info-form', require('./frontend/components/checkout/CheckoutUserInfoForm').default);
Vue.component('checkout-order-comment', require('./frontend/components/checkout/CheckoutOrderComment').default);

const store = new Vuex.Store({
    modules: {
        selectCar,
        garage,
        Cart,
        Checkout,
        productShow,
        Search,
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
    require('./themejs/script');
};
