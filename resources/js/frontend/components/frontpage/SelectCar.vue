<template>
    <div>
        <select name="" id="" v-model="selectedYear" class="form-control" @change="filterModificationsBySelectedYear">
            <option value="">Не выбрано</option>
            <option
                :value="year"
                v-for="year in years"
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
        {{ models }}
        <select v-if="step >=3" name="" v-model="modelSelected" class="form-control" @change="loadModifications">
            <option value="">Не выбрано</option>
            <option
                :value="model.id"
                v-for="model in models"
                v-text="model.name"

            ></option>
        </select>
        <p>{{filteredModifications}}</p>
        <select v-if="step >=4" name="" v-model="modificationSelected" class="form-control" @change="choseModification">
<!--        <select name="" v-model="modificationSelected">-->
            <option value="">Не выбрано</option>
            <option :value="modification.id" v-for="modification in filteredModifications" v-text="modification.name"></option>
        </select>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations} from 'vuex'

    export default {
        props: ['auto_brands'],
        data() {
            return {
                selectedYear: "",
                brandSelected: "",
                modelSelected: "",
                modificationSelected: "",
                step: 1,
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
            })
        },
        methods: {
            ...mapMutations({
                addBrands: 'selectCar/addBrands',
                addModels: 'selectCar/addModels',
                addModifications: 'selectCar/addModifications',
                clearModifications: 'selectCar/clearModifications',
                addFilteredModifications: 'selectCar/addFilteredModifications'
            }),

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
                return validModels;
            },

            filterModificationsBySelectedYear() {
                if(this.selectedYear) this.step++;

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

            resetModelsSelect() {
                this.modelSelected = "";
            },

            loadModels(brand) {

                if(this.brandSelected) this.step++;

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
            loadModifications() {
                if(this.modelSelected) this.step++;
                if(!this.modelSelected)  {
                    return this.modificationSelected = "";
                }

                var self = this;
                let form = new FormData();
                form.append('model_id', self.modelSelected);
                axios.post('/api/tecdoc/get-modifications', form)
                    .then(data => {
                        self.addModifications(data.data);
                        self.filterModificationsBySelectedYear();
                    })
            },
            choseModification() {
                window.location.href = this.modificationSelected+"/categories/";
            }
        }
    }
</script>
