<template>
    <div>
        <div>
            <treeselect
                :multiple="true"
                :options="options"

                v-model="value"
            />
            <pre class="result">{{ value }}</pre>
            <p><strong>Value consists of:</strong></p>
            <input type="hidden" v-model="value" name="tree234">
        </div>
    </div>
</template>

<script>
    import TecdocCategoriesNodeTree from "./TecdocCategoriesNodeTree";
    import {mapState, mapGetters, mapMutations} from 'vuex'
    import Treeselect from '@riophae/vue-treeselect'
    // import the styles
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'

    export default {
        props: ['categories', 'category_distinct_tecdoc_categories', 'disabled_distinct_tecdoc_categories'],

        components: {
             Treeselect
        },

        data() {
            return {
                localCategories: this.categories,
                value: this.category_distinct_tecdoc_categories,
                options: this.categories,
                disabled: this.disabled_distinct_tecdoc_categories
            }
        },
    }
</script>
