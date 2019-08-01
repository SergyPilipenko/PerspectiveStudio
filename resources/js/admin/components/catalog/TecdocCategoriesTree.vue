<template>
    <div>
        <div class="tree">
            <div class="row">
                <ul class="tree-list">
                    <tecdoc-categories-node-tree :node="category" v-for="(category) in categories" :key="category.id"></tecdoc-categories-node-tree>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import TecdocCategoriesNodeTree from "./TecdocCategoriesNodeTree";

    export default {
        props: ['categories'],

        components: {
            TecdocCategoriesNodeTree
        }
    }
</script>
