<template>
    <div>
        <accordian>
            <div slot="header">Группы</div>
            <div slot="body">
                <new-attribute-group-form ref="added" @addGroup="addGroup" :action="action"></new-attribute-group-form>
                <accordian v-for="(group, index) in groups" :key="group.id">
                    <div slot="header">
                        {{ group.name }}
                    </div>
                    <div slot="icon" v-if="group.isNew | group.is_user_defined"><i class="ti-trash" @click="removeGroup(group)"></i></div>
                    <div slot="body">
                        <attributes-table
                            :group="group"
                            @closeOtherAttributesLists="hideAttrTable"
                            @removeFromAvailableAttributesList="removeFromAvailableAttributesList"
                            @addToAvailableAttributesList="addToAvailableAttributesList"
                            ref="attr"
                            :availableAttributes="availableAttributes"
                        ></attributes-table>
                    </div>
                </accordian>
            </div>
        </accordian>
    </div>
</template>
<script>
    import Accordian from "../../../../components/Accordian";
    import NewAttributeGroupForm from "./NewAttributeGroupForm";
    import AttributesTable from "./AttributesTable";

    export default {
        props: ['action', 'default_groups', 'custom_attributes'],
        components: { Accordian, NewAttributeGroupForm, AttributesTable },

        data() {
            return {
                groups: [],
                newGroups: [],
                availableAttributes: [
                ]
            }
        },
        created() {
            this.groups = JSON.parse(this.default_groups);
            this.availableAttributes = JSON.parse(this.custom_attributes);
        },

        methods: {
            checkGroupName(object, newGroup) {
                for (let i in object) {
                    if(object[i].name == newGroup.name) return false;
                } return true;
            },
            attributeGroupDoesNotExists(newGroup) {
                if(this.checkGroupName(this.groups, newGroup)) {
                    return true
                } else return false;
            },
            addGroup(newGroup) {
                if(this.attributeGroupDoesNotExists(newGroup) == true) {
                    newGroup.isNew = true;
                    var groups = this.groups;
                    groups.push(newGroup);
                    this.groups = groups;
                    this.$refs.added.clearAndCloseForm()
                } else {
                    flash('Группа с таким именем уже существует', 'error');
                }
            },
            addToAvailableAttributesList(attribute) {
                var available = this.availableAttributes;
                available.push(attribute);
                this.availableAttributes = available;
            },
            removeFromAvailableAttributesList(attributes) {
                var filtered = this.availableAttributes.filter(item => {
                    return !attributes.includes(item.id);
                });
                this.availableAttributes = filtered;
            },
            hideAttrTable() {
                for(let i in this.groups) {
                    this.$refs.attr[i].hideAttributes()
                }
            },
            removeGroup(rmGroup) {
                for(let i in this.groups) {
                    if(this.groups[i].name == rmGroup.name) {
                        this.$refs.attr[i].recoverAvailableAttributes()
                    }
                }

                var filteredGroups = this.groups.filter(group => {
                    return group.name != rmGroup.name
                });

                this.groups = filteredGroups;
            }
        }
    }
</script>
