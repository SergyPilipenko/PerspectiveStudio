<template>
    <div>
        <treeselect v-model="value"
                    :multiple="true"
                    :options="options"
                    :flat="true"
                    :default-expand-level="1"
        />
        <input type="hidden" name="categories" :value="value">
    </div>
</template>
<script>
    import Treeselect from '@riophae/vue-treeselect'

    export default {
        components: { Treeselect },
        props: ['product_categories', 'selected_categories', 'locale'],

        data() {
            return {
                categories: null,
                value: null,
                options: null
            }
        },
        created() {
            this.categories = this.product_categories;
            this.options = this.toTree(this.categories);
            var selectedCategories = JSON.parse(this.selected_categories);
            var defaultValue = [];
            if(selectedCategories.length) {
                for (let i in selectedCategories) {
                    defaultValue.push(selectedCategories[i].id)
                }
                this.value = defaultValue;
            }
        },
        methods: {
            toTree(categories) {
                var options = [];
                for (let i in categories) {
                    var option = {};
                    option.id = categories[i].id;
                    option.label = categories[i].category_title[this.locale];
                    if(categories[i].children.length) {
                        option.children = this.toTree(categories[i].children);
                    }
                    options.push(option);
                }
                return options;
            }
        }
    }
</script>
