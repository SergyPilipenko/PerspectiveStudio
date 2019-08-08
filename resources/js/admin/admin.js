import Vuex from "vuex";

require('../bootstrap');

window.Vue = require('vue');
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);

window.events = new Vue();

window.flash = function (message, level = 'success', errors = undefined) {
    window.events.$emit('flash', {message, level, errors});
};

Vue.component('flash', require('../components/Flash.vue').default);
Vue.component('confirm', require('../components/Confirm.vue').default);
Vue.component('accordion-list', require('../components/Accordion.vue').default);
Vue.component('category-image', require('./components/catalog/CategoryImageUpload.vue').default);
Vue.component('parser', require('./components/parser/parser.vue').default);
Vue.component('art-cross', require('./components/products/ArtCross.vue').default);
Vue.component('product-edit-photos', require('./components/products/ProductEditPhotos.vue').default);
Vue.component('brands-tree', require('./components/products/BrandsTree.vue').default);
Vue.component('models-tree', require('./components/products/ModelsTree.vue').default);
Vue.component('tecdoc-categories-tree', require('./components/catalog/TecdocCategoriesTree.vue').default);
Vue.component('modifications-tree', require('./components/products/ModificationsTree.vue').default);
Vue.component('catalog-settings', require('./components/catalog/settings.vue').default);
Vue.component('import-edit', require('./components/parser/Edit.vue').default);
Vue.component('import-price', require('./components/parser/ImportPrice.vue').default);

import CategoriesCheckboxes from './components/vuex/categories-checkboxes';

const store = new Vuex.Store({
    modules: {
        CategoriesCheckboxes,
    }
});

window.onload = function () {
    const app = new Vue({
        el: '#app',
        store

    });
};

