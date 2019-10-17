<template>
    <form id="model" class="search__body search__model align-items-center justify-content-center">
        <div class="search__model-cover" @click="showSelect('year')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">1</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Год</span>
                </div>
            </div>
            <span class="search__model-arrow">
                <img src="/img/frontend/img/arrow-down.png" alt="img">
            </span>
            <div @click.stop  :class="{'search__model-dropdown active' : isVisible('year'), 'search__model-dropdown' : !isVisible('year')}">
                <span v-for="year in getYearsList" v-text="year" @click="setYear(year)"></span>
            </div>
        </div>
        <div class="search__model-cover" @click="showSelect('bodyType')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">2</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Кузов</span>
                </div>
            </div>
            <span class="search__model-arrow">
                <img src="/img/frontend/img/arrow-down.png" alt="img">
            </span>
            <div @click.stop  :class="{'search__model-dropdown active' : isVisible('bodyType'), 'search__model-dropdown' : !isVisible('bodyType')}">
                <span v-for="bodyType in getBodyTypes" v-text="bodyType.displayvalue" @click="setCarBodyType(bodyType.displayvalue)"></span>
            </div>
        </div>
        <div class="search__model-cover" @click="showSelect('engineType')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">3</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Тип Двигателя</span>
                </div>
            </div>
            <span class="search__model-arrow">
                <img src="/img/frontend/img/arrow-down.png" alt="img">
            </span>
            <div @click.stop  :class="{'search__model-dropdown active' : isVisible('engineType'), 'search__model-dropdown' : !isVisible('engineType')}">
                <span v-for="(engine, engineType) in getEngines">
                        <div v-text="engineType"></div>
                        <div class="capacity-container">
                            <div class="capacity" v-for="capacity in engine">
                                <span v-text="capacity" @click="setCarCapacity(capacity, engineType)"></span>
                            </div>
                        </div>
                </span>
            </div>
        </div>
        <div class="search__model-cover" @click="showSelect('modification')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">4</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Модификация</span>
                </div>
            </div>
            <span class="search__model-arrow">
                <img src="/img/frontend/img/arrow-down.png" alt="img">
            </span>
            <div @click.stop :class="{'search__model-dropdown active' : isVisible('modification'), 'search__model-dropdown' : !isVisible('modification')}">
                <span
                    @click="chooseModification(route['auto.model']+'-'+modification.id)"
                    v-for="modification in getModifications">
                    {{ modification.fulldescription }} ({{ modification.enginePower }})
                </span>
            </div>
        </div>
    </form>
<!--    <div>-->
<!--        <div>-->
<!--            <label for="year" v-if="!yearSelected"></label>-->
<!--            <select name="year"-->
<!--                    v-model="yearSelected" class="form-control"-->
<!--                    @change="setYear">-->
<!--                <option value="">Не выбрано</option>-->
<!--                <option :value="year" v-for="year in getYearsList" v-text="year"></option>-->
<!--            </select>-->
<!--        </div>-->
<!--        <select name="" v-model="selectedBodyType" class="form-control" @change="setCarBodyType">-->
<!--            <option value="">Не выбрано</option>-->
<!--            <option :value="bodyType.displayvalue"-->
<!--                    v-for="bodyType in getBodyTypes"-->
<!--                    v-text="bodyType.displayvalue"-->
<!--            ></option>-->
<!--        </select>-->
<!--        <div>-->
<!--            <ul>-->
<!--                <li v-for="(engine, engineType) in getEngines">-->
<!--                    {{engineType}}-->
<!--                    <ul>-->
<!--                        <li v-for="capacity in engine">-->
<!--                            <a href="#" v-text="capacity" @click.prevent="setCarCapacity(capacity, engineType)"></a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </div>-->
<!--        <div v-if="getModifications">-->
<!--            <div v-for="modification in getModifications">-->
<!--                <a :href="route['auto.model']+'-'+modification.id">-->
<!--                    {{ modification.fulldescription }} ({{ modification.enginePower }})-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        props: ['year', 'actions', 'models'],

        data() {
            return {
                yearSelected: this.year,
                route: JSON.parse(this.actions),
                filteredModels: this.getFilteredModelsByYear,
                bodyTypes: this.getBodyTypes,
                selectedBodyType: "",
                selects: [
                    {
                        id: 1,
                        name: 'year',
                        visible: false
                    },
                    {
                        id: 2,
                        name: 'bodyType',
                        visible: false
                    },
                    {
                        id: 3,
                        name: 'engineType',
                        visible: false
                    },
                    {
                        id: 4,
                        name: 'modification',
                        visible: false
                    }
                ],
            }
        },

        created() {
            this.setYearsList(this.years);
            this.setModels(this.convertModelsBackendData());
            this.filterModelsByYear({models: this.getModels, selectedYear: this.yearSelected});
            this.pluck({value: 'id', items: this.getFilteredModelsByYear});
            this.setBodyTypes(
                    {
                        action: this.route['get-models-body-types'],
                        model_Ids: this.getPluckedData
                    }
                )
        },

        computed: {
            ...mapGetters({
                years: 'selectCar/getYears',
                getYearsList: 'selectCar/getYearsList',
                getBodyTypes: 'selectCar/getBodyTypes',
                getModels: 'selectCar/getModels',
                getFilteredModelsByYear: 'selectCar/getFilteredModelsByYear',
                getPluckedData: 'selectCar/getPluckedData',
                getEngines: 'selectCar/getEngines',
                getModifications: 'selectCar/getModifications',
            }),

            modificationRoute(modificationId) {
                return this.route['auto.model']+'-'+modificationId
            }
        },

        methods: {
            ...mapActions({
                setCarYear: 'selectCar/setCarYear',
                setYearsList: 'selectCar/setYearsList',
                setModels: 'selectCar/setModels',
                filterModelsByYear: 'selectCar/filterModelsByYear',
                setBodyTypes: 'selectCar/setBodyTypes',
                pluck: 'selectCar/pluck',
                setEngines: 'selectCar/setEngines',
                setModifications: 'selectCar/setModifications'
            }),

            setCarBodyType(bodyType) {
                this.selectedBodyType = bodyType;
                this.pluck({value: 'id', items: this.getFilteredModelsByYear});
                this.setEngines({
                    modelIds: this.getPluckedData,
                    selectedBodyType: this.selectedBodyType,
                    selectedYear: this.yearSelected,
                    action: this.route['get-models-engines'],
                });
                this.showSelect('engineType');
            },

            setCarCapacity(capacity, engineType) {
                this.pluck({value: 'id', items: this.getFilteredModelsByYear});
                this.setModifications({
                    action: this.route['get-filtered-modifications'],
                    model_Ids: this.getPluckedData,
                    EngineType: engineType,
                    BodyType: this.selectedBodyType,
                    Capacity: capacity,
                });
                this.showSelect('modification');
            },

            setYear(year) {
                this.yearSelected = year;
                // this.hideAllSelects();
                this.selectedBodyType = "";
                this.setCarYear({action: this.route['set-car-year'], yearSelected: this.yearSelected});
                this.filterModelsByYear({models: this.getModels, selectedYear: this.yearSelected});
                this.pluck({value: 'id', items: this.getFilteredModelsByYear});

                this.setBodyTypes(
                    {
                        action: this.route['get-models-body-types'],
                        model_Ids: this.getPluckedData
                    }
                );
                this.showSelect('bodyType');
            },
            showSelect(name) {
                this.hideAllSelects(name);
                var selects = this.selects;
                for(let i in selects) {
                    if(selects[i].name == name) {
                        selects[i].visible = !selects[i].visible;
                    }
                };
                this.selects = selects;
            },
            chooseModification(route) {
                window.location.href = route;
            },
            convertModelsBackendData() {
                let models = this.models;
                let data = [];
                if(models.length) {
                    for (let el in models) {
                        data.push(models[el].model);
                    }
                }
                return data;
            },
            hideAllSelects(except = null) {
                var selects = this.selects;
                for(let i in selects) {
                    if(except) {
                        if(selects[i].name != except) {
                            selects[i].visible = false
                        }
                    } else {
                        selects[i].visible = false
                    }
                };
                this.selects = selects;
            },
            isVisible(name) {
                for(let i in this.selects) {
                    if(this.selects[i].name == name) {
                        return this.selects[i].visible
                    }
                }
            },
        }
    }
</script>
