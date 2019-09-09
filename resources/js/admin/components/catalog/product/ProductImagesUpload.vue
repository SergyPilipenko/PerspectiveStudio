<template>
    <div>
        <div class="product-image-upload-container">
            <div class="form-group" v-for="image in imagesList">
                <product-image-item
                    :image="image"
                    :key="image.id"
                    @removeImage="removeImage"
                >
                </product-image-item>
            </div>
        </div>
        <input type="hidden" name="imagesList" :value="imgList">
        <button type="button" class="btn-primary btn-sm" @click="addImageForm">Добавить изображение</button>
    </div>
</template>
<script>
    import ProductImageItem from './ProductImageItem'

    export default {
        components: { ProductImageItem },
        props: ['images_list'],
        data() {
            return {
                url: '',
                imagesList: [],
                idCounter: 0
            }
        },
        created() {
            if(!this.imagesList.length) this.addImageForm();
            if(this.images_list) {
                this.imagesList = JSON.parse(this.images_list);
            };
            if(this.imagesList.length) {
                for(let i in this.imagesList) {
                    if(this.imagesList[i].id > this.idCounter) {
                        this.idCounter = this.imagesList[i].id;
                    }
                }
                this.idCounter++;
            }
        },
        computed: {
            imgList() {
                return JSON.stringify(this.imagesList)
            }
        },
        methods: {
            addImageForm() {
                var images = this.imagesList;
                var img = {
                    path: '',
                    id: this.idCounter,
                };
                images.push(img);
                this.images = images;
                this.idCounter++;
            },
            removeImage(id) {
                var images = this.imagesList.filter(image => {
                    if(image.id != id) return image;
                });
                this.imagesList = images;
            }
        }
    }
</script>
