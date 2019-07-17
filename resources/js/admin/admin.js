require('../bootstrap');

window.Vue = require('vue');

window.events = new Vue();

window.flash = function (message, level = 'success', errors = undefined) {
    window.events.$emit('flash', {message, level, errors});
};

Vue.component('flash', require('../components/Flash.vue').default);
Vue.component('parser', require('./components/parser/parser.vue').default);
Vue.component('import-edit', require('./components/parser/Edit.vue').default);
Vue.component('import-price', require('./components/parser/ImportPrice.vue').default);

window.onload = function () {

    const app = new Vue({
        el: '#app'
    });
};

