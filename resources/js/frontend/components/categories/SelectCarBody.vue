<template>
    <form id="model" class="search__body search__model align-items-center justify-content-center">
        <div class="search__model-cover" @click="showSelect('year')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">1</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Год</span>
                    <span class="search__model-subtext" v-if="yearSelected" v-text="yearSelected"></span>
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
                    <span class="search__model-subtext" v-if="selectedBodyType" v-text="selectedBodyType"></span>
                </div>
            </div>
            <span class="search__model-arrow">
                <img src="/img/frontend/img/arrow-down.png" alt="img">
            </span>
            <div @click.stop  :class="{'search__model-dropdown active' : isVisible('bodyType'), 'search__model-dropdown' : !isVisible('bodyType')}">
                <span v-for="bodyType in getBodyTypes" v-text="bodyType.displayvalue" @click="setCarBodyType(bodyType.displayvalue)"></span>
            </div>
        </div>
        <div :class="{'search__model-cover disabled' : step < 3, 'search__model-cover' : step >= 3}" @click="showSelect('engineType')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">3</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Тип Двигателя</span>
                    <span class="search__model-subtext" v-if="selectedEngineType" v-text="selectedEngineType"></span>
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
        <div :class="{'search__model-cover disabled' : step < 4, 'search__model-cover' : step >= 4}" @click="showSelect('modification')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">4</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Модификация</span>
                    <span class="search__model-subtext" v-if="selectedModification" v-text="selectedModification"></span>
                </div>
            </div>
            <span class="search__model-arrow">
                <img src="/img/frontend/img/arrow-down.png" alt="img">
            </span>
            <div @click.stop :class="{'search__model-dropdown active' : isVisible('modification'), 'search__model-dropdown' : !isVisible('modification')}">
                <span
                    @click="chooseModification(route['auto.model']+'-'+modification.id, modification)"
                    v-for="modification in getModifications">
                    {{ modification.fulldescription }} ({{ modification.enginePower }})
                </span>
            </div>
        </div>
    </form>
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
                selectedEngineType: "",
                selectedModification: "",
                step: 1,
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
            if(this.year) {
                this.step = 2;
            }
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
                this.step = 3;
                this.clearSelectedEngineType();
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
                this.step = 4;
                this.pluck({value: 'id', items: this.getFilteredModelsByYear});
                this.setModifications({
                    action: this.route['get-filtered-modifications'],
                    model_Ids: this.getPluckedData,
                    EngineType: engineType,
                    BodyType: this.selectedBodyType,
                    Capacity: capacity,
                });
                this.selectedEngineType = engineType + ' ' + capacity;
                this.showSelect('modification');
            },
            clearSelectedEngineType(){
                this.selectedEngineType = "";
                this.clearSelectedModification();
            },
            clearSelectedModification() {
                this.selectedModification = "";
            },
            setYear(year) {
                this.step = 2;
                this.yearSelected = year;
                this.clearSelectedEngineType();
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
                // console.log(name);
                if(name == 'engineType' && this.step < 3) return;
                if(name == 'modification' && this.step < 4) return;
                this.hideAllSelects(name);
                var selects = this.selects;
                for(let i in selects) {
                    if(selects[i].name == name) {
                        selects[i].visible = !selects[i].visible;
                    }
                };
                this.selects = selects;
            },
            chooseModification(route, modification) {
                window.location.href = route;
                this.selectedModification = modification.fulldescription + modification.enginePower;
                this.hideAllSelects();
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
