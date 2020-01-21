<template>
    <div class="MenuPanel">
        <div class="Menu__panel"
            :style="[
                functionalityStyle,
                positionStyle,
                (isTranslating) ? transitionStyle : {}
            ]"
        >
            <div v-if="list.title" @click="handleHeaderClicked" class="Menu__header">
                <span v-show="showHeaderArrow" class="arrow">
                    <LeftArrowIcon />
                </span>
               <h3>{{ list.title }}</h3>
            </div>


                <div v-for="item in list.children"
                    @click="handleItemClicked(item)"
                    class="header__popup-catalog-item"
                >
                    <img v-if="item.image"  src="this.image" alt="catalog">
                    <img v-else src="http://partfix.loc/img/catalog-img.png" v-if="item.title" alt="catalog">
                    <a :href="item.link"> {{ item.title }}</a>
                    <!--<span v-show="item.children.length > 0" class="arrow">
                        <RightArrowIcon />
                    </span>-->
                </div>

        </div>
    </div>
</template>

<script>
import RightArrowIcon from './icons/RightArrowIcon.vue';
import LeftArrowIcon from './icons/LeftArrowIcon.vue';

export default {
    components: {
        RightArrowIcon,
        LeftArrowIcon,
    },
    props: {
        list: {
            type: Object,
            required: true,
        },
        positionStyle: {
            type: Object,
            required: true,
        },
        showHeaderArrow: {
            type: Boolean,
            default: false,
        },
        isTranslating: {
            type: Boolean,
            default: false,
        },
        handleHeaderClicked: {
            type: Function,
            default: () => {},
        },
        handleItemClicked: {
            type: Function,
            default: () => {},
        },

        // @TODO: create createMenuPanel.js to assign `functionalityStyle` which is not diff from next, staging, and prev panel in parent component.
        functionalityStyle: {
            type: Object,
            required: true,
        },
        transitionStyle: {
            type: Object,
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped>

ul, li {
    padding: 0;
    margin: 0;
}

.Menu__header {
    display: flex;
    align-items: center;
    padding-left: 35px;
    height: 50px;

    font-size: 16px;

    cursor: pointer;

    .arrow {
        padding-top: 2px;

        margin-right: 10px;
        width: 10px;
        height: 100%;
        display: flex;
        align-items: center;
    }
}

.Menu__list {
    list-style: none;
    padding-bottom: 2px;

    .separator {
        border-bottom: 1px solid #d5dbdb;
        padding: 2px 0 0 0;
        margin: 0;
    }
}

.Menu__item {
    padding-left: 35px;
    height: 45px;
    display: flex;
    align-items: center;
    cursor: pointer;

    .arrow {
        padding-top: 2px;
        padding-left: 15px;
        display: flex;
        align-items: center;
        width: 10px;
        height: 100%;
    }
}
</style>
