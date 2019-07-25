<template>
    <div class="col-md-4 article_brands_tree">
        <div class="form-group" v-for="brand in autoBrands">
            <div class="form-check form-check-flat form-check-primary d-flex align-content-center flex-column">
                <div class="d-flex flex-row">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">
                        {{ brand.name }}
                        <i class="input-helper"></i></label>
                    <button @click="loadMoreItems(brand.id)"><i class="ti-plus"></i></button>
                </div>
                {{ brand.id }}
                <div v-if="brand.models">
                    <models-tree
                            :models="brand.models"
                            :get_modifications="get_modifications"
                    ></models-tree>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['brands', 'get_models', 'get_modifications'],
        data() {
            return {
                models: [],
                autoBrands: this.brands
            }
        },
        methods: {
            addModels(data, brand_id) {
                const brandWithModels = this.autoBrands;
                for(let el in brandWithModels) {
                    if(brandWithModels[el].id == brand_id) {
                        brandWithModels[el].models = data.data;
                        this.autoBrands = Object.assign({}, this.autoBrands, brandWithModels);
                        break;
                    }
                }
            },
            loadMoreItems(brand_id) {
                let self = this;
                let formData = new FormData();
                formData.append('brand_id', brand_id);

                axios.post(this.get_models, formData)
                    .catch(error => {
                        var message = "";
                        if(error.response.data.message) {
                            message = error.response.data.message
                        } else if(error.response.data.exception) {
                            message = error.response.data.exception
                        } else {
                            message = "Не удалось сохранить схему загрузки";
                        }
                        flash(message, 'error', error.response.data.errors)
                    })
                    .then(function (data) {
                        self.addModels(data, brand_id);
                    });
            }
        }
    }
</script>

<style>
    .article_brands_tree label{
        margin-bottom: 0;
    }
</style>