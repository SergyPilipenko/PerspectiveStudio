<template>
    <div class="col-3 d-lg-none d-flex justify-content-end">
        <button class="header__search-magnify" @click="show">
            <img src="/img/frontend/img/svg/search.svg" alt="search">
        </button>
    </div>
</template>

<script>
    import {mapMutations} from 'vuex'
    export default {
        methods: {
            ...mapMutations({
                'showModalSearch': 'Search/showModalSearch'
            }),
            show() {
                this.showModalSearch();
            }
        }
    }
</script>

<style scoped>

</style>
