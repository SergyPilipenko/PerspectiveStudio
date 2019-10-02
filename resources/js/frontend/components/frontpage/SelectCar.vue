<template>
    <form class="search__body search__model align-items-center justify-content-center" id="model">
        <div class="search__model-cover" @click="showSelect('year')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">1</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Год выпуска</span>
                    <span class="search__model-subtext" v-if="selectedYear" v-text="selectedYear"></span>
                </div>
            </div>
            <span class="search__model-arrow"><img src="/img/frontend/img/arrow-down.png" alt="img"></span>
            <div @click.stop :class="{'search__model-dropdown active' : isVisible('year'), 'search__model-dropdown' : !isVisible('year')}">
                <span v-for="year in rangeYears" v-text="year" @click="setYear(year)"></span>
            </div>
        </div>
        <div class="search__model-cover" @click="showSelect('brand')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">2</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Марка</span>
                    <span class="search__model-subtext" v-if="brandSelected" v-text="brandSelected.description"></span>
                </div>
            </div>
            <span class="search__model-arrow"><img src="/img/frontend/img/arrow-down.png" alt="img"></span>
            <div @click.stop :class="{'search__model-dropdown active' : isVisible('brand'), 'search__model-dropdown' : !isVisible('brand')}">
                <span v-for="brand in brands"
                      v-text="brand.description" @click="setBrand(brand)"></span>
            </div>
        </div>
        <div class="search__model-cover" @click="showSelect('models')">
            <div class="d-flex align-items-center">
                <span class="search__model-number">3</span>
                <div class="d-flex flex-column">
                    <span class="search__model-text">Модель</span>
                    <span class="search__model-subtext" v-if="modelSelected" v-text="modelSelected.name"></span>
                </div>
            </div>
            <span class="search__model-arrow"><img src="/img/frontend/img/arrow-down.png" alt="img"></span>
            <div @click.stop :class="{'search__model-dropdown active' : isVisible('models'), 'search__model-dropdown' : !isVisible('models')}">
                <span
                    v-for="model in getModelsDistinct"
                    v-text="model.name" @click="setModel(model)"></span>
            </div>
        </div>
        <button type="submit">Выбрать</button>
    </form>
<!--    <div>-->
<!--        <select name="" id="" v-model="selectedYear" class="form-control" @change="filterModificationsBySelectedYear">-->
<!--            <option value="">Не выбрано</option>-->
<!--            <option-->
<!--                :value="year"-->
<!--                v-for="year in rangeYears"-->
<!--                v-text="year"-->
<!--            ></option>-->
<!--        </select>-->
<!--        <select v-if="step >=2" name="" @change="loadModels(brandSelected)" class="form-control" v-model="brandSelected">-->
<!--            <option value="">Не выбрано</option>-->
<!--            <option-->
<!--                :value="brand.id"-->
<!--                v-for="brand in brands"-->
<!--                v-text="brand.description"-->
<!--            ></option>-->
<!--        </select>-->
<!--        <select v-if="step >=3" name="" v-model="modelSelected" class="form-control" @change="loadModifications">-->
<!--            <option value="">Не выбрано</option>-->
<!--            <option-->
<!--                :value="model.id"-->
<!--                v-for="model in getModelsDistinct"-->
<!--                v-text="model.name"-->

<!--            ></option>-->
<!--        </select>-->
<!--    </div>-->
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        //удачи! ^_^
        props: ['auto_brands', 'routes'],
        data() {
            return {
                modificationSelected: "",
                step: 0,
                rangeYears: [],
                bodyTypeSelected: "",
                selectedEngine: "",
                selects: [
                    {
                        id: 1,
                        name: 'year',
                        visible: false
                    },
                    {
                        id: 2,
                        name: 'brand',
                        visible: false
                    },
                    {
                        id: 3,
                        name: 'models',
                        visible: false
                    }
                ],
                // selectedYear: ""
            }
        },
        created() {
            let years = [];
            let first = this.years[0];
            while (first <= this.years[1]) {
                years.push(first);
                first++;
            }
            this.rangeYears = years.reverse();
        },
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
                selectedYear: 'selectCar/getSelectedYear',
                brandSelected: 'selectCar/getSelectedBrand',
                modelSelected: 'selectCar/getSelectedModel',
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
                addSelectedYead: 'selectCar/addSelectedYead',
                clearSelectedBrand: 'selectCar/clearSelectedBrand',
                clearSelectedModel: 'selectCar/clearSelectedModel',
                addSelectedModel: 'selectCar/addSelectedModel',
                addSelectedBrand: 'selectCar/addSelectedBrand',
            }),

            ...mapActions({
                setCarYear: 'selectCar/setCarYear',
                setBrands: 'selectCar/setBrands',
                clearModels: 'selectCar/clearModels'
            }),
            setYear(year){
                this.addSelectedYead(year);
                this.filterModificationsBySelectedYear();
                this.hideAllSelects();
                this.showSelect('brand');

            },
            setBrand(brand) {
                this.addSelectedBrand(brand);
                this.loadModels(brand.id);
                this.hideAllSelects();
                this.showSelect('models');
            },
            setModel(model) {
                this.addSelectedModel(model);
                this.hideAllSelects();
                this.loadModifications();
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
            isVisible(name) {
                for(let i in this.selects) {
                    if(this.selects[i].name == name) {
                        return this.selects[i].visible
                    }
                }
            },
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
                this.clearSelectedBrand();
                this.clearModels();
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
                this.clearSelectedModel();
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

                var modelSelected = this.getModelById(this.modelSelected.id);

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
                var brandSelected = this.getBrandById(this.brandSelected.id);
                var modelSelected = this.getModelById(this.modelSelected.id);
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
