<template>
    <div class="card__main-left">
        <div class="card__main-list">
            <div v-for="image in product_images"><img :src="'/' + image.path" alt="card-img" @click="changeMainImg(image)"></div>
<!--            <div class="youtube"><img src="/img/frontend/img/youtube.png" alt="youtube"><span>видео</span></div>-->
        </div>
        <div class="card__main-img">
            <img :src="mainImg" alt="card-img">
        </div>
    </div>
</template>
<script>
    export default {
        props: ['product_images'],
        data() {
            return {
                mainImg: ''
            }
        },
        created() {
            if(this.product_images.length) {
                this.mainImg = '/' + this.product_images[0].path;
            }
        },
        methods: {
            changeMainImg(image) {
                this.mainImg = '/' + image.path
            }
        }
    }
</script>
