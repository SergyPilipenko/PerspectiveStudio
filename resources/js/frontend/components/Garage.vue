<template>
    <div class="header__punkt header__car">
        <img src="/img/frontend/img/svg/car.svg" alt="car" class="icon">
        <span class="header__punkt-counter" v-text="getCars.length"></span>
        <span class="header__punkt-title">Гараж</span>
        <img src="/img/frontend/img/arrow-down.png" alt="img" class="arrow">
        <div class="header__car-dropdown" v-if="getCars.length">
            <span class="close"><img src="/img/frontend/img/cross.png" alt="img"></span>
            <h3>Ваш гараж</h3>
            <div class="d-flex flex-column header__car-dropdown-list">
                <div class="header__car-dropdown-item" v-for="car in getCars">
                    <div class="d-flex flex-column">
                        <a :href="car.path" class="header__car-dropdown-item-title"
                           v-text="car.year + ' ' + car.brand.description + ' ' + car.model.description"></a>
                        <span
                            v-text="formatCapacity(car.Capacity) + ' '
                            + ucfirst(car.FuelType) + ', '
                            + car.BodyType.toLowerCase() + ', '
                            + formatPower(car.Power)"> CRTF</span>
                    </div>
                    <a :href="car.path" class="catalog">Каталог</a>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between header__car-buttons">
                <button class="header__car-dropdown-add">Добавить</button>
                <button class="header__car-dropdown-clear" @click="clearGarage">Очистить</button>
            </div>
        </div>
        <div class="header__car-dropdown" v-else>
            <span class="close"><img src="/img/frontend/img/cross.png" alt="img"></span>
            <h3>Ваш гараж пуст</h3>
        </div>
    </div>

<!--    <div style="padding-bottom: 100px" v-if="getCars.length">-->
<!--        <h1>Ваш гараж</h1>-->

<!--        <div class="row">-->
<!--            <button id="garag-select" type="button"-->
<!--                    class="btn btn-default dropdown-toggle garage-item"-->
<!--                    @click="toggleGarageList"-->
<!--                    aria-expanded="false"-->
<!--                    v-text="getCurrentAuto.fulldescription"-->
<!--            ><span class="caret"></span>-->
<!--            </button>-->
<!--            <div>-->
<!--                {{ getCurrentAuto.selectedYear }}г.,-->
<!--                {{ getAutoAttribute({attribute: 'Capacity', auto: getCurrentAuto}) }},-->
<!--                {{ getAutoAttribute({attribute: 'EngineType', auto: getCurrentAuto}) }},-->
<!--                {{ getAutoAttribute({attribute: 'BodyType', auto: getCurrentAuto}) }},-->
<!--                ({{ getAutoAttribute({attribute: 'EngineCode', auto: getCurrentAuto}) }},-->
<!--                {{ getAutoPower({attribute: 'Power', auto: getCurrentAuto}) }})-->
<!--            </div>-->
<!--        </div>-->

<!--        <div v-if="garageList">-->
<!--            <div v-for="car in getCars">-->
<!--                <div class="row">-->
<!--                    <a href="#" @click.prevent="changeCar(car.id)">-->
<!--                        <div v-text="car.fulldescription"></div>-->
<!--                    </a>-->
<!--                    <a class="button btn btn-danger" :href="'/garage-remove-car/' + car.id" style="margin-left: 15px">X</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        props: ['garage', 'current_auto', 'new_garage'],

        data() {
            return {
                garageList: false,
                grg: []
            }
        },
        created() {
            var garage = this.new_garage;
            if(garage && garage.cars) {
                this.setCars(garage.cars);
                this.setCurrentAuto(garage.activeCar);
            }
        },
        computed: {
            ...mapGetters({
                'getCars': 'garage/getCars',
                'getCurrentAuto': 'garage/getCurrentAuto'
            }),
        },
        methods: {
            formatCapacity(capacity) {
                var float = parseFloat(capacity.replace(/[^0-9\.,]/g, ''));

                return float.toFixed(1);
            },
            formatPower(power) {
                return power.replace(/\D+/g, '') + ' л.с'
            },
            ucfirst(str) {
                if (typeof str !== 'string') return '';
                return str.charAt(0).toUpperCase() + str.slice(1)
            },
            clearGarage() {
                console.log(1);
                window.location.href = "/garage-clear"
            },
            getCurrentAutoById(current_auto) {
                const cars = this.getCars;
                for(let i in cars) {
                    if(cars[i].id == current_auto.modification_id)  {
                        cars[i].selectedYear = current_auto.modification_year;
                        return cars[i];
                    } continue;
                }
            },

            getAutoAttribute(payload) {
                const auto = payload.auto;
                const attribute = payload.attribute;
                for (let i in auto.attributes) {
                    if(auto.attributes[i].attributetype == attribute) {
                        return auto.attributes[i].displayvalue
                    };
                }
            },

            changeCar(id) {
                window.location.href = 'change-current-car/' + id
            },

            getAutoPower(payload) {
                const auto = payload.auto;
                const attribute = payload.attribute;
                var reg = new RegExp('PS');
                for (let i in auto.attributes) {
                    if(auto.attributes[i].attributetype == "Power" && reg.test(auto.attributes[i].displayvalue)) {
                        return auto.attributes[i].displayvalue.replace(reg, 'л.с')
                    };
                }
            },

            ...mapActions({
                'setCars': 'garage/setCars',
                'setCurrentAuto': 'garage/setCurrentAuto',
            }),

            ...mapMutations({}),

            toggleGarageList() {
                this.garageList = !this.garageList;
            }
        }
    }
</script>
