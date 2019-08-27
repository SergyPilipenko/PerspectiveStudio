<template>
    <div>
        <ul v-if="items">
            <li v-for="category in categories">
                <a :href="'/admin/categories/'+category.id+'/edit'" :class="{'badge badge-warning' : category.id == current.category}">{{ category.title }}</a>
                <button v-if="category.children.length" type="button" class="primary" @click="toggleChildrenVisibility(category)">+</button>
                <ul v-if="category.children">
                    <categories-tree-element
                        v-show="category.visibility"
                        :items="category.children"
                        :current_category="current"></categories-tree-element>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>

    export default {
        props: ['items', 'current_category'],

        data() {
            return {
                categories: this.items,
                current: this.current_category,
            }
        },

        created() {
            this.categories = this.getCategories
        },

        computed: {
            getCategories() {
                var categories = JSON.parse(this.items);
                for (let el in categories) {
                    categories[el].visibility = false;
                }
                return categories;
            }
        },

        methods: {
            toggleChildrenVisibility(category) {
                category.visibility = !category.visibility;
            }
        }
    }
</script>

<style>
    /*ul {*/
    /*    list-style: none;*/
    /*}*/
</style>
