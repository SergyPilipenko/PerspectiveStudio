<template>
    <div class="subcategory__sidebar-block">
        <p class="filter-attribute-title" @click="toggleBlock(block.id)" @mouseover="showDescription(block.id)" @mouseleave="hideDescription(block.id)">
            <span class="plus">+</span>
            <span class="minus">−</span>
            <span class="card__main-icon-dropdown" v-if="block.showDescription" v-text="block.description"></span>
            {{ block.title }}
        </p>

        <div v-if="block.show">
            <div
                class="subcategory__sidebar-line"
                v-if="block.showAllOptions || index < getMaxOptionsShowCount"
                v-for="(option, index) in block.options"
                @click="toggleOption({blockId: block.id, optionIndex: index})">
                <div class="d-flex align-items-center curp">
                    <div :class="{'checkbox': !option.selected, 'checkbox checked': option.selected}">
                        <img src="/img/frontend/img/svg/checked.svg" alt="checked">
                    </div>
                    <span>{{ option.value }}</span>
                </div>
                <span class="quantity">{{ option.count }}</span>
                <a @click.stop :href="option.link" class="price-filter__submit js-filter" v-if="option.showSubmitLink">
                    <span class="price-filter__submit-link">
                        Показать                    </span>
                    (<span id="priceFilterCount" v-text="option.submitQty"></span>)
                </a>
            </div>
            <div class="subcategory__sidebar-show"
                 v-if="!block.showAllOptions && block.options.length > getMaxOptionsShowCount"
                @click="showAllOptions(block.id)"
            >
                <img src="/img/frontend/img/plus.png" alt="plus">
                <span>Показать еще</span>
            </div>
            <div class="subcategory__sidebar-show"
                 v-else-if="block.showAllOptions && block.options.length > getMaxOptionsShowCount"
                 @click="showAllOptions(block.id)">
                <img src="/img/frontend/img/plus.png" alt="plus">
                <span>Скрыть</span>
            </div>
        </div>
    </div>

</template>

<script>
    import {mapGetters, mapActions, mapMutations} from 'vuex'

    export default {
        props: ['filter_block', 'options'],
        created() {
            var options = this.options;
            for (let i in options) {
                options[i].selected = this.isSelected({
                    blockCode: this.filter_block.attribute.code,
                    value: options[i].value
                });
                options[i].showSubmitLink = false;
                options[i].submitQty = 0;
                options[i].link = '';
            }
            this.setRequestParameters();
            var block = {
                id: this.filter_block.attribute.id,
                title: this.filter_block.attribute.title,
                code: this.filter_block.attribute.code,
                type: this.filter_block.attribute.type,
                description: this.filter_block.attribute.description,
                options: options,
                showAllOptions: false,
                showDescription: false,
                show: true
            };
            this.addBlock(block);
        },
        computed: {
            block() {
                return this.getBlockById(this.filter_block.attribute.id);
            },
            ...mapGetters({
                blocks: 'CatalogFilter/getBlocks',
                getBlockById: 'CatalogFilter/getBlockById',
                getRequestParams: 'CatalogFilter/getRequestParams',
                getMaxOptionsShowCount: 'CatalogFilter/getMaxOptionsShowCount',
                isSelected: 'CatalogFilter/isSelected',
            }),
        },
        methods: {
            ...mapActions({
                addBlock: 'CatalogFilter/addBlock',
                toggleOption: 'CatalogFilter/toggleOption',
            }),
            ...mapMutations({
                toggleBlock: 'CatalogFilter/toggleBlock',
                showAllOptions: 'CatalogFilter/showAllOptions',
                setRequestParameters: 'CatalogFilter/setRequestParameters',
                showDescription: 'CatalogFilter/showDescription',
                hideDescription: 'CatalogFilter/hideDescription',
            })
        }
    }
</script>
<style>
    .subcategory__sidebar-block .filter-attribute-title {
        position: relative;
    }
    .subcategory__sidebar-block .card__main-icon-dropdown {
        position: absolute;
        z-index: 10;
        color: rgb(255, 255, 255);
        font-size: 12px;
        min-width: 110px;
        text-align: center;
        padding: 5px;
        background: rgb(76, 76, 76);
        border-radius: 5px;
        display: block;
        top: 27px;
        left: 6px;
    }
</style>
