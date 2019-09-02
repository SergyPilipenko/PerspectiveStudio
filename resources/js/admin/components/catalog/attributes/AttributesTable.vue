<template>
    <div>
        <div class="table-responsive" v-if="group.attributes && group.attributes.length">
            <table class="table">
                <thead>
                <tr>
                    <th>Код</th>
                    <th>Название</th>
                    <th>Тип</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="attribute in group.attributes">
                    <td v-text="attribute.code"></td>
                    <td v-text="attribute.title"></td>
                    <td v-text="attribute.type"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <button class="btn small btn-primary btn-sm add-attribute-btn" @click="toggleVisibility">Добавить аттрибут</button>
        <div v-if="visibility">
            <div class="form-check form-check-flat form-check-primary " v-for="attribute in availableAttributes">
                <label class="form-check-label">
                    {{ attribute.title }}
                    <input type="checkbox" name="checkbox" attr="1" class="form-check-input auto_type_head_checkbox">
                    <i class="input-helper"></i><i class="input-helper"></i>
                </label>
            </div>
            <button class="btn btn-sm btn-primary">Добавить</button>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['group', 'availableAttributes'],

        data() {
            return {
                visibility: false
            }
        },

        methods: {
            toggleVisibility() {
                this.visibility = !this.visibility;
            }
        }
    }
</script>
