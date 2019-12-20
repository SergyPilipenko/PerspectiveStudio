import Vuex from "vuex";

require('../bootstrap');
// var CKEDITOR_BASEPATH = '/js/libs/ckeditor/';
// require('../libs/ckeditor/ckeditor.js');

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
Vue.component('slugify-title', require('./components/catalog/SlugifyTitle.vue').default);
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
Vue.component('categories-tree', require('./components/catalog/CategoriesTree').default);
Vue.component('categories-tree-element', require('./components/catalog/CategoriesTreeElement').default);
Vue.component('auto-types-table', require('./components/auto/AutoTypesTable').default);
Vue.component('attribute-groups', require('./components/catalog/attributes/AttributeGroups').default);
Vue.component('product-images-upload', require('./components/catalog/product/ProductImagesUpload').default);
Vue.component('category-image-upload', require('./components/catalog/product/categories/CategoryImageUploadForm').default);
Vue.component('partfix-ckeditor', require('../components/PartfixCkeditor.vue').default);

Vue.component('product-categories', require('./components/catalog/product/ProductCategories').default);
Vue.component('accordian', require('../components/Accordian').default);

import CategoriesCheckboxes from './components/vuex/categories-checkboxes';
import autoTypes from "../frontend/store/modules/auto-types";


const store = new Vuex.Store({
    modules: {
        CategoriesCheckboxes,
        autoTypes,
    }
});

window.onload = function () {
    const app = new Vue({
        el: '#app',
        store
    });
    if(document.getElementById('ckeditor')) {
        CKEDITOR.replace( 'ckeditor', {
            extraPlugins: 'uploadimage',
            uploadUrl: '/admin/ckeditor-upload-image',
            allowedContent: true
        });
    }
    if(document.getElementById('ckeditor-short_description')) {
        CKEDITOR.replace( 'ckeditor-short_description', {
            extraPlugins: 'uploadimage',
            uploadUrl: '/admin/ckeditor-upload-image',
            allowedContent: true
        });
    }
    if(document.getElementById('ckeditor-description')) {
        CKEDITOR.replace( 'ckeditor-description', {
            extraPlugins: 'uploadimage',
            uploadUrl: '/admin/ckeditor-upload-image',
            allowedContent: true
        });
    }


    if($(".auto_type_head_checkbox")) {
        $(".auto_type_head_checkbox").on('change', function (e) {
            var headerCheckBoxAttr = $(this).attr("attr");
            var checked = this.checked;
            $.each($('.category_checkbox[attr="'+headerCheckBoxAttr+'"]'), function (i,el) {
                el.checked = checked;
            });
        })
        $(".category_checkbox").on('change', function () {
            var headerCheckBoxAttr = $(this).attr("attr");
            if($('.category_checkbox[attr="'+headerCheckBoxAttr+'"]:checked').length == $('.category_checkbox[attr="'+headerCheckBoxAttr+'"]').length) {
                $('.auto_type_head_checkbox[attr="'+headerCheckBoxAttr+'"]').prop('checked', true)
            } else  {
                $('.auto_type_head_checkbox[attr="'+headerCheckBoxAttr+'"]').prop('checked', false)
            }
        });
    }

    if($(".product-edit #name")) {
        function find(str) {
            var arrru = new Array ('Я','я','Ю','ю','Ч','ч','Ш','ш','Щ','щ','Ж','ж','А','а','Б','б','В','в','Г','г','Д','д','Е','е','Ё','ё','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н', 'О','о','П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ы','ы','Ь','ь','Ъ','ъ','Э','э','-','/','.');
            var arren = new Array ('Ya','ya','Yu','yu','Ch','ch','Sh','sh','Sh','sh','Zh','zh','A','a','B','b','V','v','G','g','D','d','E','e','E','e','Z','z','I','i','J','j','K','k','L','l','M','m','N','n', 'O','o','P','p','R','r','S','s','T','t','U','u','F','f','H','h','C','c','Y','y','','','\'','\'','E', 'e','-','-','-');

            var ru = arrru.indexOf(str);
            var en = arrru.indexOf(str);
            var needle = '';
            if(ru != -1) {
                needle = arren[ru];
            } else if(en != -1) {
                needle = arren[en];
            }
            return needle;
        }

        function slugify(str) {
            var splitTitle =  str;
            splitTitle = splitTitle.toLowerCase();
            splitTitle = splitTitle.replace(/\s+/g, '-');
            splitTitle = splitTitle.split("");
            for(let i in splitTitle) {
                var reg = new RegExp('[a-zA-Z0-9]');
                if(reg.test(splitTitle[i])) {
                    splitTitle[i] = splitTitle[i];
                    continue;
                } else {
                    splitTitle[i] = find(splitTitle[i]);
                }
            }

            splitTitle = splitTitle.join("");

            return splitTitle;
        }

        var name = $(".product-edit #name"),
            slug = $(".product-edit #slug");

        name.on('input', function() {
            slug.val(slugify($(this).val()));
        })
    }
};
