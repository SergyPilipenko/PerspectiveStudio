<template>
    <div>
        <div class="catalog__choose_car_container">
            <select-car v-if="getPopupLayout" :auto_brands="auto_brands"
                        :routes="routes"></select-car>
        </div>
        <button @click="toggleShowSelectCar" v-if="!getPopupLayout" v-text="btnText"></button>
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
                'getCurrentAuto': 'garage/getCurrentAuto',
                'getPopupLayout': 'General/getPopupLayout',
            }),
            ...mapMutations({
                'togglePopupBlackLayout': 'General/togglePopupBlackLayout'
            }),
            btnText() {
                return this.getCurrentAuto ? 'Изменить' : 'Выбрать авто'
            }
        },
        methods: {
            toggleShowSelectCar() {
                // this.showSelectCar = !this.showSelectCar;
                this.togglePopupBlackLayout;
            },

        }
    }
</script>
