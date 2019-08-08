<template>
    <div>

        <div v-if="current_image" class="grid-margin">
            <img :src="'/'+current_image" alt="#" class="category-image">
        </div>
        <!-- Styled -->
        <b-form-file
            v-model="file"
            :state="Boolean(file)"
            :placeholder="current_image ? 'Изменить изображение' : 'Добавить изображение'"
            :name="'category_image'"
            drop-placeholder="Drop file here..."
        ></b-form-file>
    </div>
</template>
<script>
    export default {
        props: ['current_image']
    }
</script>
<style>
    .category-image {
        max-width: 300px;
    }
</style>
