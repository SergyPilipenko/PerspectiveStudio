<template>
    <div style="padding-bottom: 100px" v-if="getCars.length">
        <h1>Ваш гараж</h1>

        <div class="row">
            <button id="garag-select" type="button"
                    class="btn btn-default dropdown-toggle garage-item"
                    @click="toggleGarageList"
                    aria-expanded="false"
                    v-text="getCurrentAuto.fulldescription"
            ><span class="caret"></span>
            </button>
            <div>
                {{ getCurrentAuto.selectedYear }}г.,
                {{ getAutoAttribute({attribute: 'Capacity', auto: getCurrentAuto}) }},
                {{ getAutoAttribute({attribute: 'EngineType', auto: getCurrentAuto}) }},
                {{ getAutoAttribute({attribute: 'BodyType', auto: getCurrentAuto}) }},
                ({{ getAutoAttribute({attribute: 'EngineCode', auto: getCurrentAuto}) }},
                {{ getAutoPower({attribute: 'Power', auto: getCurrentAuto}) }})
            </div>
        </div>

        <div v-if="garageList">
            <div v-for="car in getCars">
                <div class="row">
                    <a href="#" @click.prevent="changeCar(car.id)">
                        <div v-text="car.fulldescription"></div>
                    </a>
                    <a class="button btn btn-danger" :href="'/garage-remove-car/' + car.id" style="margin-left: 15px">X</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        props: ['garage', 'current_auto'],

        data() {
            return {
                garageList: false,
            }
        },
        created() {
            if(this.garage.length) {
                this.setCars(this.garage);
                this.setCurrentAuto(this.getCurrentAutoById(JSON.parse(this.current_auto)));
            }
        },
        computed: {
            ...mapGetters({
                'getCars': 'garage/getCars',
                'getCurrentAuto': 'garage/getCurrentAuto'
            }),
        },
        methods: {

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
