<template>
    <div>
        <div class="d-flex justify-content-between">
            <span class="subcategory__sidebar-chosen">Вы выбрали:</span><a :href="getCategoryLink" class="subcategory__sidebar-cancel">Сбросить все</a>
        </div>
        <div class="d-flex flex-column align-items-start subcategory__sidebar-options">
            <div class="subcategory__sidebar-picked" v-for="filter in getAppliedFilters" @click="deleteFilterOption(filter.link)">
                <span>{{ filter.title }}: {{ filter.value }}</span>
                <img src="/img/frontend/img/cross-red.png" alt="cross-red">
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapGetters({
                getRequestParams: 'CatalogFilter/getRequestParams',
                getAppliedFilters: 'CatalogFilter/getAppliedFilters',
                getCategoryLink: 'CatalogFilter/getCategoryLink'
            })
        },
        methods: {
            deleteFilterOption(href) {
                window.location.href = href;
            }
        }
    }
</script>
