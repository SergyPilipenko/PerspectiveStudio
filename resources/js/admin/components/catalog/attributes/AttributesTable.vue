<template>
    <div>
        <div class="table-responsive" v-if="attributesList && attributesList.length">
            <table class="table">
                <thead>
                <tr>
                    <th>Код</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="attribute in attributesList">
                    <td v-text="attribute.code"></td>
                    <td v-text="attribute.title"></td>
                    <td v-text="attribute.type"></td>
                    <td>
                        <a href="#" @click.prevent="removeAttributeFromGroupList(attribute)"><i class="ti-trash" v-if="attribute.new | attribute.is_user_defined"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn small btn-primary btn-sm add-attribute-btn" @click="toggleVisibility">Добавить аттрибут</button>
        <div v-if="visibility">
            <div class="form-check form-check-flat form-check-primary " v-for="(attribute, index) in availableAttributes">
                <label class="form-check-label">
                    {{ attribute.title }}
                    <input type="checkbox" name="checkbox" class="form-check-input" v-model="checked[index]">
                    <i class="input-helper"></i>
                </label>
            </div>
            <button type="button" class="btn btn-sm btn-primary" v-if="availableAttributes.length" @click="addAttributesInGroupList">Добавить</button>
            <div v-else>список пуст...</div>
        </div>
        <input type="hidden" :name="'groups['+group.name+']'" :value="groupAttributesIds">
    </div>
</template>
<script>
    export default {
        props: ['group', 'availableAttributes'],

        data() {
            return {
                visibility: false,
                checked: [],
                available: [],
                attributesList: []
            }
        },

        mounted() {

            if(this.group.attributes) {
                this.attributesList = this.group.attributes;
            }
        },

        computed: {
            groupAttributesIds() {
                var obj = {
                    group: this.group,
                    attributes: this.attributesList
                };
                return JSON.stringify(obj)
            }
        },

        methods: {

            hideAttributes() {
                this.visibility = false;
            },

            clearChecked() {
                this.checked = [];
            },

            toggleVisibility() {
                this.$emit('closeOtherAttributesLists');
                this.visibility = !this.visibility;
            },
            addAttributesInGroupList() {
                var checkedAttributes = this.attributesList,
                    newItemsIds = [];
                this.checked.map((item, index) => {
                    if(item) {
                        this.availableAttributes[index].new = true;
                        checkedAttributes.push(this.availableAttributes[index]);
                        newItemsIds.push(this.availableAttributes[index].id);
                    }
                });
                this.attributesList = checkedAttributes;
                this.$emit('removeFromAvailableAttributesList', newItemsIds);
                this.hideAttributes();
                this.clearChecked();
            },
            removeAttributeFromGroupList(attribute) {
                var filtered = [],
                    available = [];
                for(let i in this.attributesList) {
                    if(this.attributesList[i].id != attribute.id) {
                        filtered.push(this.attributesList[i]);
                    } else {
                        available = this.attributesList[i];
                    }
                }
                this.attributesList = filtered;

                this.$emit('addToAvailableAttributesList', available);
            },

            removeAllAttributes() {
                this.attributesList.map(item => {
                    this.$emit('addToAvailableAttributesList', item);
                });
                this.attributesList = [];
            },

            recoverAvailableAttributes() {
                if(this.attributesList.length) {
                    this.removeAllAttributes();
                }
            }
        }
    }
</script>
