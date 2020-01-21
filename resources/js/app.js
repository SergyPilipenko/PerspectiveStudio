/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
import Vuex from 'vuex';
import selectCar from './frontend/store/modules/select-car';
import garage from './frontend/store/modules/garage';
import productShow from './frontend/store/modules/productShow';
import Cart from './frontend/store/modules/cart';
import Checkout from './frontend/store/modules/checkout';
import Search from './frontend/store/modules/search';
import General from './frontend/store/modules/general';
import CatalogFilter from "../../packages/partfix/catalog-category-filter/src/assets/js/store/modules/catalog-filter-store";
import VueRouter from 'vue-router';
import VueNestedMenu from 'vue-nested-menu';


window.lang = document.documentElement.lang;
window.Vue = require('vue');
Vue.config.devtools = true;
Vue.use(Vuex);
Vue.use(VueRouter);




Vue.component('search-button', require('./frontend/components/Search/SearchButton').default);
Vue.component('mobile-search-button', require('./frontend/components/Search/MobileSearchButton').default);
Vue.component('search-tabs', require('./frontend/components/frontpage/SearchTabs').default);
Vue.component('select-car', require('./frontend/components/frontpage/SelectCar').default);
Vue.component('select-car-body', require('./frontend/components/categories/SelectCarBody').default);
Vue.component('add-to-cart', require('./frontend/components/product/AddToCart').default);
Vue.component('product-gallery', require('./frontend/components/product/ProductGallery').default);
Vue.component('garage', require('./frontend/components/Garage').default);
Vue.component('search', require('./frontend/components/Search/Search').default);
Vue.component('product-show', require('./frontend/components/product/Show').default);
Vue.component('cart', require('./frontend/components/cart/Cart').default);
Vue.component('checkout', require('./frontend/components/checkout/Checkout').default);
Vue.component('checkout-cart', require('./frontend/components/checkout/CheckoutCart').default);
Vue.component('checkout-user-info-form', require('./frontend/components/checkout/CheckoutUserInfoForm').default);
Vue.component('checkout-order-comment', require('./frontend/components/checkout/CheckoutOrderComment').default);
Vue.component('smt', require('./frontend/components/Smt').default);
Vue.component('catalog-filter', require('../../packages/partfix/catalog-category-filter/src/assets/js/components/CatalogFilter').default);
Vue.component('mobile-nav', require('./frontend/components/MobileNav').default);
Vue.component('choose-car-button', require('./frontend/components/ChooseCarButton').default);
Vue.component('popup-black-layout', require('./frontend/components/PopupBlackLayout').default);

const store = new Vuex.Store({
    modules: {
        selectCar,
        garage,
        Cart,
        Checkout,
        productShow,
        Search,
        CatalogFilter,
        General
    }
});

const router = new VueRouter({
    mode: 'history',
    routes: [],
});
export default router;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.onload = function () {
    const app = new Vue({
        el: '#app',
        store,
        router
    });
    require('./themejs/script');
    require('./themejs/script-extensions');
};
