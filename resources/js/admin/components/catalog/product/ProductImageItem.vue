<template>
    <div class="image-item-container">
        <label>
            <div class="image-item">
                <input type="file" ref="file"  name="img[]" @change="uploadImage" class="file-upload-default">
                <div class="upload-image-button" v-if="!img.path">
                    <i class="ti-image"></i>
                </div>
                <div v-else>
                    <img :src="imgPath(img)" alt="">
                </div>
            </div>
        </label>
        <div class="image-item-remove-btn" @click="removeImage(img.id)">
            <i class="ti-close"></i>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['image', 'value', 'images_list'],

        data() {
            return {
                img: {},
            }
        },
        created() {
            this.img = this.image
        },

        methods: {
            addImage(file) {
                this.img.path = file;
            },
            uploadImage() {
                const file = this.$refs.file.files[0];
                const reg = new RegExp('image');
                if(file.type && reg.test(file.type)) {
                    this.addImage(URL.createObjectURL(file));
                }
            },
            removeImage(id) {
                this.$emit('removeImage', id)
            },
            imgPath(img) {
                return img.product_id ? '/' + img.path : img.path
            }

        }
    }
</script>
