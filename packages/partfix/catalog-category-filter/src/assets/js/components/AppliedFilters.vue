<template>
    <div>
        <ul>
            <li v-for="filter in getAppliedFilters">
                <a :href="filter.link">{{ filter.title }}: {{ filter.value }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapGetters({
                getRequestParams: 'CatalogFilter/getRequestParams',
                getAppliedFilters: 'CatalogFilter/getAppliedFilters'
            })
        }
    }
</script>
