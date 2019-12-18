<template>
    <form class="search__body search__model align-items-center justify-content-center" id="model">
        <div class="search__model-cover" @click="showSelect('year')">
            <input type="text" v-model="inputYear" @input="filterYears">
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
        <div :class="{'search__model-cover disabled' : step < 2, 'search__model-cover' : step >= 2}" @click="showSelect('brand')">
            <input type="text" v-model="inputBrand" @input="filterBrands">
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
        <div :class="{'search__model-cover disabled' : step < 3, 'search__model-cover' : step >= 3}" @click="showSelect('models')">
            <input type="text" v-model="inputModel" @input="filterModels">
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
        <button type="button" @click="goToCarCatalog">Выбрать</button>
    </form>
</template>
<script>
    import {mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        //удачи! ^_^
        props: ['auto_brands', 'routes'],

        data() {
            return {
                modificationSelected: "",
                step: 0,
                inputYear: '',
                inputBrand: '',
                inputModel: '',
                rangeYears: [],
                bodyTypeSelected: "",
                selectedEngine: "",
                redirecting: false,
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
            }
        },
        created() {
            this.setYearsList();
            if(this.getCurrentAuto) {
                this.addSelectedYead(this.getCurrentAuto.year);
                this.addSelectedBrand({
                    description: this.getCurrentAuto.brand.description,
                    id: this.getCurrentAuto.brand.id
                });
                this.setBrands({
                    action: this.route['get-brands-by-models-created-year'],
                    selected_year: this.selectedYear
                });
                this.addSelectedModel({
                    id: this.getCurrentAuto.model.id,
                    constructioninterval: this.getCurrentAuto.model.constructioninterval,
                    name: this.getCurrentAuto.model.description
                });
                this.getModelsFromApi(this.brandSelected.id);
            }
        },
        computed: {
            route() {
                return JSON.parse(this.routes);
            },

            ...mapGetters({
                years: 'selectCar/getYears',
                brands: 'selectCar/getBrands',
                getBrandsStore: 'selectCar/getBrandsStore',
                getDistinctModelsStore: 'selectCar/getDistinctModelsStore',
                models: 'selectCar/getModels',
                modifications: 'selectCar/getModifications',
                filteredModifications: 'selectCar/getFilteredModifications',
                getModelsDistinct: 'selectCar/getDistinctModels',
                getBodyTypes: 'selectCar/getBodyTypes',
                getEngines: 'selectCar/getEngines',
                selectedYear: 'selectCar/getSelectedYear',
                brandSelected: 'selectCar/getSelectedBrand',
                modelSelected: 'selectCar/getSelectedModel',
                getCurrentAuto: 'garage/getCurrentAuto',
            }),



        },

        methods: {

            ...mapMutations({
                addBrands: 'selectCar/addBrands',
                addBrandsStore: 'selectCar/addBrandsStore',
                addModels: 'selectCar/addModels',
                addModifications: 'selectCar/addModifications',
                clearModifications: 'selectCar/clearModifications',
                addFilteredModifications: 'selectCar/addFilteredModifications',
                addDistinctModels: 'selectCar/addDistinctModels',
                addDistinctModelsStore: 'selectCar/addDistinctModelsStore',
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
            setYearsList() {
                let years = [];
                let first = this.years[0];
                while (first <= this.years[1]) {
                    years.push(first);
                    first++;
                }
                this.rangeYears = years.reverse();
            },
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
                //work around
                if(name == 'brand' && this.step < 2) return;
                if(name == 'models' && this.step < 3) return;
                // console.log(name);
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
                    }
                });
                var distinctModels = this.distinctModels(validModels);
                this.addDistinctModels(distinctModels);
                this.addDistinctModelsStore(distinctModels);

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
                    }
                });
                this.addFilteredModifications(validModifications);

                this.setCarYear({action: '/set-car-year', yearSelected: this.selectedYear});
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

                this.getModelsFromApi(brand);
                this.resetModelsSelect();
                this.clearModifications();
            },
            getModelsFromApi(brand) {
                var self = this;
                let form = new FormData();
                form.append('brand_id', brand);

                axios.post('/api/tecdoc/get-models', form)
                    .then(data => {
                        self.addModels(self.filterModelsBySelectedYear(data.data));
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
                this.redirecting = true;
                window.location.href = this.getSelectedModelURI();
                var self = this;
                let form = new FormData();
                form.append('model_Ids', modelSelectedIds);
                axios.post('/api/tecdoc/get-models-body-types', form)
                    .then(data => {
                        self.addBodyTypes(data.data);
                    })
            },
            choseModification() {
                window.location.href = this.modificationSelected+"/categories/";
            },
            goToCarCatalog() {
                if(!this.selectedYear) {
                    this.showSelect('year');
                    return;
                }
                if(!this.brandSelected) {
                    this.showSelect('brand');
                    return;
                }
                if(!this.modelSelected) {
                    this.showSelect('models');
                    return;
                }
                if(!this.redirecting){
                    window.location.href = this.getCurrentAuto.path
                }
            },

            filterYears() {
                if(!this.inputYear) {
                    this.setYearsList();
                } else {
                    function sortNumber(a, b) {
                        return a + b;
                    }

                    let inputData = parseInt(this.inputYear);
                    var reg = new RegExp(inputData);
                    var filtered = this.rangeYears.filter(item => reg.test(item));
                    if(filtered.length) {
                        this.rangeYears = filtered.sort(sortNumber);
                    }
                }
            },
            filterBrands() {
                if(!this.inputBrand) {
                    this.addBrands(this.getBrandsStore);
                } else {
                    var reg = new RegExp(this.inputBrand.toUpperCase());
                    var filtered = [];
                    for(let i = 0; i <= this.getBrandsStore.length; i++) {
                        if(this.getBrandsStore[i] && this.getBrandsStore[i].description) {
                            var brand = this.getBrandsStore[i].description;
                            if(reg.test(brand)) {
                                filtered.push(this.getBrandsStore[i]);
                            }
                        }
                    }
                    this.addBrands(filtered);
                }
            },
            filterModels() {
                if(!this.inputModel) {
                    this.addModels(this.getDistinctModelsStore);
                } else {
                    var reg = new RegExp(this.inputModel.toUpperCase());
                    var filtered = [];
                    for(let i = 0; i <= this.getDistinctModelsStore.length; i++) {
                        if(this.getDistinctModelsStore[i] && this.getDistinctModelsStore[i].name) {
                            var model = this.getDistinctModelsStore[i].name;
                            if(reg.test(model)) {
                                filtered.push(this.getDistinctModelsStore[i]);
                            }
                        }
                    }

                    this.addDistinctModels(filtered);
                }
            }
        }
    }
</script>
