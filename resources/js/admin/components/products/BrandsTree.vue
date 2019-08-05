<template>
    <div class="col-md-4 article_brands_tree">
        <div class="form-group" v-for="brand in autoBrands">
            <div class="form-check form-check-flat form-check-primary d-flex align-content-center flex-column">
                <div class="d-flex flex-row">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">
                        {{ brand.name }}
                        <i class="input-helper"></i></label>
                    <button @click="loadMoreItems(brand)"><i class="ti-plus"></i></button>
                </div>
<!--                {{ brand.id }}-->
                <div v-if="brand.modelsShow">
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
        mounted() {
            this.brands.map((brand) => {
                this.$set(brand, 'modelsShow', false);
            });
        },
        methods: {
            show(brand) {
                brand.modelsShow = true;
            },
            hide(brand) {
                brand.modelsShow = false;
            },
            addModels(data, brand_id) {
                for(let el in this.autoBrands) {
                    if(this.autoBrands[el].id == brand_id) {
                        this.$set(this.autoBrands[el], 'models', data.data);
                        break;
                    }
                }
            },
            loadMoreItems(brand) {
                if(brand.modelsShow) {
                    this.hide(brand);
                    return;
                } else if(brand.models != undefined) {
                    this.show(brand);
                    return;
                }
                var brand_id = brand.id;
                if(this.modelsShow) {
                    this.hide();
                    return;
                }
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
                        self.show(brand);
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
