<template>
    <div>
        <div class="d-flex flex-column align-items-start subcategory__sidebar-options">
            <div class="subcategory__sidebar-picked" v-for="filter in getAppliedFilters" @click="deleteFilterOption(filter.link)">
                <span>{{ filter.title }}: {{ filter.value }}</span>
                <img src="/img/frontend/img/cross-red.png" alt="cross-red">
            </div>
<!--            <div class="subcategory__sidebar-picked">-->
<!--                <span>ABE</span>-->
<!--                <img src="{{ asset('img/frontend/img/cross-red.png') }}" alt="cross-red">-->
<!--            </div>-->
<!--            <div class="subcategory__sidebar-picked">-->
<!--                <span>100 - 350 грн</span>-->
<!--                <img src="{{ asset('img/frontend/img/cross-red.png') }}" alt="cross-red">-->
<!--            </div>-->
        </div>
<!--        <ul>-->
<!--            <li v-for="filter in getAppliedFilters">-->
<!--                <a :href="filter.link">{{ filter.title }}: {{ filter.value }}</a>-->
<!--            </li>-->
<!--        </ul>-->
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
        },
        methods: {
            deleteFilterOption(href) {
                window.location.href = href;
            }
        }
    }
</script>
