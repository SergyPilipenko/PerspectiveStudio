<template>
    <div>
        <ul v-if="categories.length">
            <li v-for="category in categories">
                <div class="row">
                    <a :href="'/admin/categories/'+category.id+'/edit'" :class="{'badge badge-warning' : category.id == current.category}">{{ category.title }}</a>
                    <button v-if="category.children.length" type="button" class="primary" @click="toggleChildrenVisibility(category)">+</button>
                </div>
                <div v-if="category.children">
                    <div v-show="category.visibility">
                        <categories-tree-element
                            :items="category.children"
                            :current_category="current"></categories-tree-element>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import CategoriesTreeElement from './CategoriesTreeElement';

    export default {
        props: ['items', 'current_category'],
        components: { CategoriesTreeElement },
        data() {
            return {
                categories: [],
                current: this.current_category,
            }
        },
        created() {
            this.$set(this, 'categories', this.getAllCategories);
            // this.categories = this.getCategories;
        },
        computed: {
            getAllCategories() {
                var categories = this.items;
                for (let el in this.items) {
                    this.items[el].visibility = false;
                }
                return categories;
            }
        },
        methods: {
            toggleChildrenVisibility(category) {
                category.visibility = !category.visibility;
                this.$set(this, 'categories', this.categories);
            }
        }
    }
</script>
