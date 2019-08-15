<template>
    <div>
        <div>
            <label for="year" v-if="!yearSelected"></label>
            <select name="year"
                    v-model="yearSelected" class="form-control"
                    @change="setYear">
                <option value="">Не выбрано</option>
                <option :value="year" v-for="year in getYearsList" v-text="year"></option>
            </select>
        </div>
        <select name="" v-model="selectedBodyType" class="form-control" @change="setCarBodyType">
            <option value="">Не выбрано</option>
            <option :value="bodyType.displayvalue"
                    v-for="bodyType in getBodyTypes"
                    v-text="bodyType.displayvalue"
            ></option>
        </select>
        <div>
            <ul>
                <li v-for="(engine, engineType) in getEngines">
                    {{engineType}}
                    <ul>
                        <li v-for="capacity in engine">
                            <a href="#" v-text="capacity" @click.prevent="setCarCapacity(capacity, engineType)"></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div v-if="getModifications">
            <div v-for="modification in getModifications">
                <a :href="route['auto.model']+'-'+modification.id">
                    {{ modification.fulldescription }} ({{ modification.enginePower }})
                </a>
            </div>
        </div>
    </div>
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

            setCarBodyType() {
                this.pluck({value: 'id', items: this.getFilteredModelsByYear});
                this.setEngines({
                    modelIds: this.getPluckedData,
                    selectedBodyType: this.selectedBodyType,
                    action: this.route['get-models-engines'],
                });
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
            },

            setYear() {
                this.selectedBodyType = "";
                this.setCarYear({action: this.route['set-car-year'], yearSelected: this.yearSelected});
                this.filterModelsByYear({models: this.getModels, selectedYear: this.yearSelected});
                this.pluck({value: 'id', items: this.getFilteredModelsByYear});
                this.setBodyTypes(
                    {
                        action: this.route['get-models-body-types'],
                        model_Ids: this.getPluckedData
                    }
                )
            },

            convertModelsBackendData() {
                let models = JSON.parse(this.models);
                let data = [];
                if(models.length) {
                    for (let el in models) {
                        data.push(models[el].model);
                    }
                }
                return data;
            }
        }
    }
</script>
