<template>
    <form class="header__search">
        <input type="text" placeholder="Поиск по марка/модель/год, номер запчасти, тип запчасти, производитель ...." @focus="show">
        <button type="submit"><img src="/img/frontend/img/svg/search.svg" alt="search" class="icon"></button>
    </form>
</template>
<script>
    import {mapMutations} from 'vuex'

    export default {
        data() {
            return {

            }
        },
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
