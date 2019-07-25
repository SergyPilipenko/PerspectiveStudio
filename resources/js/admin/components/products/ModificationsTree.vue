<template>
    <div class="article_models_tree">
        <div class="form-group" v-for="modification in modifications">
            <div class="form-check form-check-flat form-check-primary d-flex align-content-center flex-column">
                <div class="d-flex flex-row">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">
                        {{ modification.name }}
                        <i class="input-helper"></i></label>
<!--                    <button @click="getModifications(model.id)"><i class="ti-plus"></i></button>-->
                </div>
                {{ modification.id }}
<!--                <div v-if="model.modifications">-->
<!--                    <modifications-tree :modificaitons="model.modifications"></modifications-tree>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['modifications']
    }
</script>