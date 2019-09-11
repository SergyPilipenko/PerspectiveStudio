<template>
    <div>
        <div class="product-image-upload-container">
            <div class="form-group">
                <div>
                    <div class="image-item-container">
                        <label>
                            <div class="image-item">
                                <input type="file" ref="file" name="category_image" @change="uploadImage"class="file-upload-default">
                                <input type="hidden" name="has_image" v-model="path">
                                <input type="hidden" name="category_image" v-model="path">
                                <div class="upload-image-button" v-if="!path">
                                    <i class="ti-image"></i>
                                </div>
                                <div v-else>
                                    <img :src="path">
                                </div>
                            </div>
                        </label>
                        <div class="image-item-remove-btn" v-if="path" @click="removeImage">
                            <i class="ti-close"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        props: ['category_image'],

        data() {
            return {
                path: false
            }
        },
        created() {
            if(this.category_image) {
                this.path = '/' + this.category_image;
            }
        },
        methods: {
            addImage(file) {
                this.$set(this, 'path', file);
            },
            uploadImage() {
                const file = this.$refs.file.files[0];
                const reg = new RegExp('image');
                if(file.type && reg.test(file.type)) {
                    this.addImage(URL.createObjectURL(file));
                }
            },
            removeImage() {
                this.path = false;
            }
        }
    }
</script>
