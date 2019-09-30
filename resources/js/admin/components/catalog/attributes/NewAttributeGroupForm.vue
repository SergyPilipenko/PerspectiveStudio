<template>
    <div>
        <div>
            <b-button v-b-modal.my-modal
                      variant="primary"
                      type="button"
                      class="add-attributes-group-btn btn-sm"
                      @click="show=true">Добавить группу</b-button>
            <b-modal
                v-model="show"
                title="Новая группа"
                id="my-modal">
                <b-container fluid>
                    <div class="form-group required">
                        <label for="name">Название</label>
                        <input
                            :class="{'form-control' : true,' error': errors['name'] != undefined}"
                            type="text"
                            id="name" v-model="name" name="name">
                        <div v-for="error in errors['name']">
                            <div class="text-danger">{{ error }}</div>
                        </div>
                    </div>
                    <div  class="form-group required">
                        <label for="group_position">Сортировка</label>
                        <input
                            :class="{'form-control' : true,' error': errors['position'] != undefined}"
                            type="number" id="group_position" v-model="position" name="group_position">
                        <div v-for="error in errors['position']">
                            <div class="text-danger">{{ error }}</div>
                        </div>
                    </div>
                </b-container>
                <div slot="modal-footer" class="w-100">
                    <div class="new_group_attributes_footer_container">
                        <b-button
                            variant="secondary"
                            @click="show=false"
                        >
                            Закрыть
                        </b-button>
                        <b-button
                            variant="primary"
                            class="float-right"
                            @click="addNewGroup"
                        >
                            Добавить
                        </b-button>
                    </div>
                </div>
            </b-modal>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['action'],

        data() {
            return {
                show: false,
                position: 1,
                name: '',
                errors: {}
            }
        },

        methods: {
            resetErrors() {
                this.errors = {}
            },
            setErrors(errors) {
                this.errors = errors;
            },
            clearAndCloseForm() {
                this.show = false;
                this.position = 1;
                this.name = '';
                this.errors = {};
            },
            addNewGroup() {
                var self = this,
                    form = new FormData();
                self.resetErrors();
                form.append('name', this.name);
                form.append('position', this.position);
                axios.post(self.action, form)
                    .catch(error => {
                        self.setErrors(error.response.data.errors);
                    })
                    .then(function (data) {
                        if(data) {
                            self.$emit('addGroup', data.data);
                        }
                    });
            }
        }
    }
</script>
