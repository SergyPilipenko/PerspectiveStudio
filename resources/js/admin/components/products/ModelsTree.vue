<template>
    <div class="article_models_tree">
        <div class="form-group" v-for="model in autoModels">
            <div class="form-check form-check-flat form-check-primary d-flex align-content-center flex-column">
                <div class="d-flex flex-row">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">
                        {{ model.name }}
                        <i class="input-helper"></i></label>
                    <button @click="getModifications(model.id)"><i class="ti-plus"></i></button>
                </div>
                {{ model.id }}
                <div v-if="model.modifications">
                    <modifications-tree :modifications="model.modifications"></modifications-tree>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['models', 'get_modifications'],
        data() {
            return {
                autoModels: this.models
            }
        },
        methods: {
            addModels(data, brand_id) {
                const modelWithModifications = this.autoModels;
                for(let el in modelWithModifications) {
                    if(modelWithModifications[el].id == brand_id) {
                        modelWithModifications[el].modifications = data.data;
                        this.autoModels = Object.assign({}, this.autoModels, modelWithModifications);
                        break;
                    }
                }
            },
            getModifications(model_id) {
                let self = this;
                let formData = new FormData();
                formData.append('model_id', model_id);

                axios.post(this.get_modifications, formData)
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
                        console.log(data);
                        self.addModels(data, model_id);
                    });
            }
        }
    }
</script>
<style>
    .article_models_tree {
        margin-left: 20px;
    }
</style>