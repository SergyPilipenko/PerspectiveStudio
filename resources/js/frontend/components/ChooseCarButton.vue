<template>
    <div>
        <select-car v-if="showSelectCar" :auto_brands="auto_brands"
                    :routes="routes"></select-car>
        <button @click="toggleShowSelectCar" v-else v-text="btnText"></button>
    </div>
</template>
<script>
    import SelectCar from './frontpage/SelectCar'
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        props: ['auto_brands', 'routes'],
        components: { SelectCar },

        data() {
            return {
                showSelectCar: false
            }
        },
        computed: {
            ...mapGetters({
                'getCars': 'garage/getCars',
                'getCurrentAuto': 'garage/getCurrentAuto'
            }),
            btnText() {
                return this.getCurrentAuto ? 'Изменить' : 'Выбрать авто'
            }
        },
        methods: {
            toggleShowSelectCar() {
                this.showSelectCar = !this.showSelectCar
            },

        }
    }
</script>
