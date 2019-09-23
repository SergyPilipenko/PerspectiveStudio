<template>
    <div class="row">
        <div class="col-md-2">
            <div class="input-group">
                <label for="importFileUpload">
                    <input type="file" name="file" ref="file" class="form-control file-upload-info" id="importFileUpload"
                           @change="handleFileUpload">
                    <span class="input-group-append">
<!--                  <button class="file-upload-browse btn btn-primary" type="button">Upload</button>-->
                </span>
                </label>

            </div>
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-success" id="importUploadSubmit" @click="submitForm(type)" value="Загрузить">
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
                action: ''
            }
        },

        methods: {
            submitForm() {
                let self = this;
                let formData = new FormData();

                formData.append('type', this.type);
                formData.append('file', this.file);

                axios.post(this.action, formData).then(function (data) {
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
