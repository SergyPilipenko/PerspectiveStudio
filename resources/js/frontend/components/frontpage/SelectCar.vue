<template>
    <div>
        <select name="" id="" v-model="selectedYear" class="form-control" @change="filterModificationsBySelectedYear">
            <option value="">Не выбрано</option>
            <option
                :value="year"
                v-for="year in rangeYears"
                v-text="year"
            ></option>
        </select>
        <select v-if="step >=2" name="" @change="loadModels(brandSelected)" class="form-control" v-model="brandSelected">
            <option value="">Не выбрано</option>
            <option
                :value="brand.id"
                v-for="brand in brands"
                v-text="brand.description"
            ></option>
        </select>
        <select v-if="step >=3" name="" v-model="modelSelected" class="form-control" @change="loadModifications">
            <option value="">Не выбрано</option>
            <option
                :value="model.id"
                v-for="model in getModelsDistinct"
                v-text="model.name"

            ></option>
        </select>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        //удачи! ^_^
        props: ['auto_brands', 'routes'],
        data() {
            return {
                selectedYear: "",
                brandSelected: "",
                modelSelected: "",
                modificationSelected: "",
                step: 0,
                rangeYears: [],
                bodyTypeSelected: "",
                selectedEngine: "",
            }
        },
        created() {
            let years = [];
            let first = this.years[0];
            while (first <= this.years[1]) {
                years.push(first);
                first++;
            }
            this.rangeYears = years.reverse()
        },

        // mounted() {
        //     this.addBrands(this.auto_brands);
        // },

        computed: {
            route() {
                return JSON.parse(this.routes);
            },

            ...mapGetters({
                years: 'selectCar/getYears',
                brands: 'selectCar/getBrands',
                models: 'selectCar/getModels',
                modifications: 'selectCar/getModifications',
                filteredModifications: 'selectCar/getFilteredModifications',
                getModelsDistinct: 'selectCar/getDistinctModels',
                getBodyTypes: 'selectCar/getBodyTypes',
                getEngines: 'selectCar/getEngines',
            }),



        },

        methods: {

            ...mapMutations({
                addBrands: 'selectCar/addBrands',
                addModels: 'selectCar/addModels',
                addModifications: 'selectCar/addModifications',
                clearModifications: 'selectCar/clearModifications',
                addFilteredModifications: 'selectCar/addFilteredModifications',
                addDistinctModels: 'selectCar/addDistinctModels',
                addBodyTypes: 'selectCar/addBodyTypes',
                addEngines: 'selectCar/addEngines',
            }),

            ...mapActions({
                setCarYear: 'selectCar/setCarYear',
                setBrands: 'selectCar/setBrands'
            }),

            distinctModels(models) {

                var dm = [];

                var distModels = models.filter(model => {
                    if(!dm.includes(model.name.substr(0, model.name.indexOf(' ')))) {
                        dm.push(model.name.substr(0, model.name.indexOf(' ')));
                        return model;
                    }
                });

                return distModels;
            },

            filterModelsBySelectedYear(models) {
                const regExp = new RegExp('[0-9]{4}');
                const validModels = models.filter(model => {
                    const years = model.constructioninterval.split(' - ');
                    const createdAt = years[0].match(regExp);
                    const stopped = years[1].match(regExp);

                    if(createdAt && stopped) {
                        if(this.selectedYear >= createdAt[0] && this.selectedYear <= stopped[0]) {
                            return model
                        }
                    } else if(createdAt && !stopped) {
                        if(this.selectedYear >= createdAt[0]) {
                            return model;
                        }
                    } else {
                        console.log(this.selectedYear);
                        console.log(createdAt);
                        console.log(stopped);
                    }
                });
                this.addDistinctModels(this.distinctModels(validModels));
                return validModels;
            },

            filterModificationsBySelectedYear() {
                this.brandSelected = "";
                this.modelSelected = "";
                this.step = 2;
                this.setBrands({
                    action: this.route['get-brands-by-models-created-year'],
                    selected_year: this.selectedYear
                });
                !this.step ? this.step+=2 : this.step = this.step;

                const modifications = this.modifications;

                if(!modifications) return;

                const regExp = new RegExp('[0-9]{4}');
                const validModifications = modifications.filter(modification => {

                    const years = modification.constructioninterval.split(' - ');
                    const createdAt = years[0].match(regExp);
                    const stopped = years[1].match(regExp);

                    if(createdAt && stopped) {
                        if(this.selectedYear >= createdAt[0] && this.selectedYear <= stopped[0]) {
                            return modification
                        }
                    } else if(createdAt && !stopped) {
                        if(this.selectedYear >= createdAt[0]) {
                            return modification;
                        }
                    } else {
                        console.log(this.selectedYear);
                        console.log(createdAt);
                        console.log(stopped);
                    }
                });
                this.addFilteredModifications(validModifications);

                this.setCarYear({action: '/set-car-year', yearSelected: this.selectedYear});

                // let form = new FormData();
                // form.append('selected_year', this.selectedYear);
                // axios.post('/set-car-year', form)
                //     .then(data => {
                //         self.addModels(self.filterModelsBySelectedYear(data.data));
                //         self.resetModelsSelect();
                //         self.clearModifications();
                //     });
            },

            getBrandById(id) {
                for(let i = 0; i <= this.brands.length; i++) {
                    if(this.brands[i].id == id) return this.brands[i];
                }
            },

            getModelById(id) {
                for(let i = 0; i <= this.models.length; i++) {
                    if(this.models[i].id == id) return this.models[i];
                }
            },

            resetModelsSelect() {
                this.modelSelected = "";
            },

            loadModels(brand) {
                this.step = 3;

                if(!brand) return;

                var self = this;
                let form = new FormData();
                form.append('brand_id', brand);

                axios.post('/api/tecdoc/get-models', form)
                    .then(data => {
                    self.addModels(self.filterModelsBySelectedYear(data.data));
                    self.resetModelsSelect();
                    self.clearModifications();
                });
            },

            getSameModelIds(modelName) {
                var modelsIds = [];

                for(let i in this.models) {
                    var reg = new RegExp(modelName);
                    if(reg.test(this.models[i].name)) {
                        modelsIds.push(this.models[i].id);
                    }
                }

                return modelsIds;
            },

            getModelSelectedIds() {
                var modelSelected = this.getModelById(this.modelSelected);
                var modelName = modelSelected.name.substr(0, modelSelected.name.indexOf(' '));
                var sameModelIds = this.getSameModelIds(modelName);

                return sameModelIds;
            },



            loadEngines() {
                var modelSelectedIds = this.getModelSelectedIds();

                var self = this;
                let form = new FormData();

                form.append('model_Ids', modelSelectedIds);
                form.append('body_type', this.bodyTypeSelected.displayvalue);

                axios.post('/api/tecdoc/get-models-engines', form)
                    .then(data => {
                        self.$set(self, 'step', 5);
                        self.addEngines(data.data);
                    })
            },

            getSelectedModelURI() {
                var brandSelected = this.getBrandById(this.brandSelected);
                var modelSelected = this.getModelById(this.modelSelected);
                // var brandName = "";
                //     if(brandSelected.description == 'CITROËN') {
                //         brandName = brandSelected.description.replace(/Ë/, 'E');
                //     }
                var brandName = brandSelected.description.toLowerCase().replace(/[^\w]/g,'_');
                if(brandName == 'citro_n') brandName = 'citroen';

                var modelName = modelSelected.name.includes(" ") ? modelSelected.name.substr(0, modelSelected.name.indexOf(' ')) : modelSelected.name;
                modelName = modelName.toLowerCase();
                modelName = modelName.replace(/[-]/g, '_');

                return brandName + "-" + modelName;
            },

            loadModifications() {
                this.step = 4;

                if(!this.modelSelected)  {
                    return this.modificationSelected = "";
                }

                var modelSelectedIds = this.getModelSelectedIds();
                this.getSelectedModelURI();
                window.location.href = this.getSelectedModelURI();

                var self = this;
                let form = new FormData();
                form.append('model_Ids', modelSelectedIds);
                axios.post('/api/tecdoc/get-models-body-types', form)
                    .then(data => {
                        self.addBodyTypes(data.data);
                    })
            },
            choseEngine() {

            },
            choseModification() {
                window.location.href = this.modificationSelected+"/categories/";
            }
        }
    }
</script>
