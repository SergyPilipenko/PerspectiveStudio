<template>
    <div class="subcategory__sidebar-block">
        <p @click="toggleBlock(block.id)"><span class="plus">+</span><span class="minus">−</span>{{ block.title }}</p>
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
                // option[i].disabled = false;
            }
            this.setRequestParameters();
            var block = {
                id: this.filter_block.attribute.id,
                title: this.filter_block.attribute.title,
                code: this.filter_block.attribute.code,
                type: this.filter_block.attribute.type,
                options: options,
                showAllOptions: false,
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
            })
        }
    }
</script>
