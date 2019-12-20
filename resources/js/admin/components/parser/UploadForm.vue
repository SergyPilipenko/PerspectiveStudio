<template>
    <div class="row">
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="delimiter">Разделитель:</label>
                        <input type="text" name="delimiter" v-model="delimiter" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <label for="importFileUpload">
                        <input type="file" name="file" ref="file" class="form-control file-upload-info" id="importFileUpload"
                               @change="handleFileUpload">
                        <span class="input-group-append"></span>
                    </label>
                </div>
                <div class="col-md-4">
                    <input type="submit" class="btn btn-success" id="importUploadSubmit" @click="submitForm(type)" value="Загрузить">
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['routes','type'],

        created() {
            this.action = "/"+JSON.parse(this.routes)['admin.import.parse'];
        },


        data(){
            return {
                file: '',
                action: '',
                delimiter: ','
            }
        },

        methods: {
            submitForm() {
                let self = this;
                let formData = new FormData();

                formData.append('type', this.type);
                formData.append('file', this.file);
                formData.append('delimiter', this.delimiter);

                axios.post(this.action, formData)
                    .catch(error => {
                        var message = "";
                        if(error.response.data.message) {
                            message = error.response.data.message
                        } else if(error.response.data.exception) {
                            message = error.response.data.exception
                        } else {
                            message = "Похоже что-то пошло не так";
                        }
                        flash(message, 'error', error.response.data.errors)
                    })
                    .then(function (data) {
                    self.$emit('fileUploaded', data.data);
                });
            },
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            }
        }
    }
</script>

<style>
    #importFileUpload {
        margin-right: 0;
    }
</style>
