<template>
    <div class="filter-blocks-container__preload-layout" v-if="getPreloadLayout"></div>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        computed: {
            ...mapGetters({
                getPreloadLayout: 'CatalogFilter/getPreloadLayout'
            })
        }
    }
</script>
