<template>
    <div>
        <input type="file" name="file" ref="file" class="form-control file-upload-info" id="importFileUpload"
               @change="handleFileUpload">
        <div class="grid-margin" @click="changeImage">
            <img :src="'/'+image" alt="#" class="category-image">
        </div>
    </div>
</template>
<script>
    export default {
        props: ['current_image', 'action', 'category_id'],

        data() {
            return {
                file: '',
                image: this.current_image ? this.current_image : 'img/admin/empty.png'
            }
        },
        methods: {
            changeImage() {
                $("#importFileUpload").trigger('click');
            },
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
                let self = this;
                let formData = new FormData();

                formData.append('category_image', this.file);
                formData.append('category_id', this.category_id);

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
                        self.$set(self, 'image', data.data.file_path);
                });
            }
        }
    }
</script>
<style>
    .category-image {
        max-width: 150px;
    }
    #importFileUpload {
        display: none;
    }
    .category-image {
        cursor: pointer;
    }
</style>
