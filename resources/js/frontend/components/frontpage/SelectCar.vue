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
                v-text="brand.name"
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
        <select v-if="step >=4" name="" v-model="bodyTypeSelected" class="form-control" @change="loadEngines">
            <option value="">Не выбрано</option>
            <option
                :value="body"
                v-for="(body) in getBodyTypes"
                v-text="body.displayvalue"

            ></option>
        </select>
        {{ engines }}

<!--        <select v-if="step >=4" name="" v-model="bodyTypeSelected" class="form-control" @change="loadEngines">-->
<!--            <option value="">Не выбрано</option>-->
<!--            <option-->
<!--                :value="body"-->
<!--                v-for="(body) in engines"-->
<!--                v-text="body.displayvalue"-->

<!--            ></option>-->
<!--        </select>-->
<!--        <p>{{filteredModifications}}</p>-->
<!--        <select v-if="step >=4" name="" v-model="modificationSelected" class="form-control" @change="choseModification">-->
<!--            <option value="">Не выбрано</option>-->
<!--            <option :value="modification.id" v-for="modification in filteredModifications" v-text="modification.name"></option>-->
<!--        </select>-->
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations} from 'vuex'

    export default {
        //удачи! ^_^
        props: ['auto_brands'],
        data() {
            return {
                selectedYear: "",
                brandSelected: "",
                modelSelected: "",
                modificationSelected: "",
                step: 0,
                rangeYears: [],
                bodyTypeSelected: "",
                engines: [],
            }
        },
        created() {
            let first = this.years[0];
            while (first <= this.years[1]) {
                this.rangeYears.push(first);
                first++;
            }
        },

        mounted() {
            this.addBrands(this.auto_brands);
        },

        computed: {

            ...mapGetters({
                years: 'selectCar/getYears',
                brands: 'selectCar/getBrands',
                models: 'selectCar/getModels',
                modifications: 'selectCar/getModifications',
                filteredModifications: 'selectCar/getFilteredModifications',
                getModelsDistinct: 'selectCar/getDistinctModels',
                getBodyTypes: 'selectCar/getBodyTypes',
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
                addBodyTypes: 'selectCar/addBodyTypes'
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
                        self.engines = data.data;
                    })
            },

            loadModifications() {
                this.step = 3;

                if(!this.modelSelected)  {
                    return this.modificationSelected = "";
                }

                var modelSelectedIds = this.getModelSelectedIds();

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
            }
        }
    }
</script>
