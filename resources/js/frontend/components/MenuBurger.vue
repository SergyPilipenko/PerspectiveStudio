<template>

    <button @click="handleBurgerClicked" class="header__catalog">
        <img src="img/frontend/img/menu-black.png" alt="icon">
        <span>Каталог товаров</span>
    </button>
</template>

<script>
import MenuIcon from './icons/MenuIcon.vue';

export default {
    components: {
        MenuIcon,
    },
    props: {
        handleBurgerClicked: {
            type: Function,
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped>

.Menu__burger {
    width: 30px;
    height: 30px;
    cursor: pointer;
}
</style>
