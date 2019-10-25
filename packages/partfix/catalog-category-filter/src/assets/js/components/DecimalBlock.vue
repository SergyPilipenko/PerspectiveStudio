<template>
    <form @submit.prevent="priceSubmit(block)">
        <div class="subcategory__sidebar-block">
            <p><span class="plus">+</span><span class="minus">−</span>{{ block.title }}</p>
            <div class="d-flex align-items-center subcategory__sidebar-price">
                <input type="text" v-model="block.inputMin" @blur="blurMin">
                <span></span>
                <input type="text" v-model="block.inputMax" @blur="blurMax">
                <button type="submit">OK</button>
            </div>
        </div>
    </form>

</template>

<script>
    import {mapGetters, mapActions, mapMutations} from 'vuex'

    export default {
        props: ['filter_block', 'options'],

        created() {
            var minMax = this.getMinMaxOptionsValues();
            this.setRequestParameters();
            var block = {
                id: this.filter_block.attribute.id,
                title: this.filter_block.attribute.title,
                code: this.filter_block.attribute.code,
                type: this.filter_block.attribute.type,
                min: minMax.min,
                max: minMax.max,
                // inputMin: this.getRequestParams[this.filter_block.attribute.code + '_from'] && parseFloat(this.getRequestParams[this.filter_block.attribute.code + '_from']) >= minMax.max
                inputMin: this.getRequestParams[this.filter_block.attribute.code + '_from']
                    ? this.getRequestParams[this.filter_block.attribute.code + '_from']
                    : minMax.min,
                // inputMax: this.getRequestParams[this.filter_block.attribute.code + '_to'] && parseFloat(this.getRequestParams[this.filter_block.attribute.code + '_to']) <= minMax.max
                inputMax: this.getRequestParams[this.filter_block.attribute.code + '_to']
                    ? this.getRequestParams[this.filter_block.attribute.code + '_to']
                    : minMax.max,
                options: this.options,
                show: true,
                showAllOptions: false,
            };
            this.addBlock(block);
        },

        computed: {
            block() {
                return this.getBlockById(this.filter_block.attribute.id);
            },
            ...mapGetters({
                getBlockById: 'CatalogFilter/getBlockById',
                getRequestParams: 'CatalogFilter/getRequestParams',
            })
        },

        methods: {
            ...mapActions({
                addBlock: 'CatalogFilter/addBlock',
                priceSubmit: 'CatalogFilter/priceSubmit',
            }),
            ...mapMutations({
                setRequestParameters: 'CatalogFilter/setRequestParameters',
                addOrUpdateFirstParam: 'CatalogFilter/addOrUpdateFirstParam',
            }),
            getMinMaxOptionsValues() {
                var min = 0, max = 0;
                for (let i in this.options) {
                    var optionValue = parseFloat(this.options[i].value);
                    if(min == 0 || optionValue < min) {
                        min = optionValue;
                    }
                    if(max == 0 || optionValue > max) {
                        max = optionValue;
                    }
                }
                return {
                    min: parseFloat(min).toFixed(2),
                    max: parseFloat(max).toFixed(2)
                };
            },
            setMinDefault() {
                this.block.inputMin = this.block.min
            },
            setMaxDefault() {
                this.block.inputMax = this.block.max
            },
            blurMin() {
                var validateInput = parseFloat(this.block.inputMin);
                if(!validateInput) return this.setMinDefault();
                validateInput = parseFloat(validateInput.toFixed(2));
                if(!this.getRequestParams[this.filter_block.attribute.code + '_from']) {
                    if(validateInput < this.block.min || validateInput > this.block.inputMax) return this.setMinDefault();
                }
                this.block.inputMin = validateInput;
                this.addOrUpdateFirstParam({
                    blockCode: this.block.code + '_from',
                    value: this.block.inputMin.toString()
                });
            },
            blurMax() {
                var validateInput = parseFloat(this.block.inputMax);
                if(!validateInput) return this.setMaxDefault();
                validateInput = parseFloat(validateInput.toFixed(2));
                if(validateInput > this.block.max || validateInput < this.block.inputMin) return this.setMaxDefault();
                this.block.inputMax = validateInput;
                this.addOrUpdateFirstParam({
                    blockCode: this.block.code + '_to',
                    value: this.block.inputMax.toString()
                });
            }
        }
    }
</script>
