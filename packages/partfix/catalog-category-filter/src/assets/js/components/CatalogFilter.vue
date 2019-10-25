<template>
    <div>

    </div>
</template>

<script>
    import TextBlock from "./TextBlock";
    import DecimalBlock from "./DecimalBlock";
    import PreloadLayout from "./PreloadLayout"
    import {mapMutations} from 'vuex'

    export default {
        components: { TextBlock, PreloadLayout, DecimalBlock },
        props: ['filter_qty_action', 'category_id', 'category_link'],

        created() {
            this.setRequestParameters();
            this.setFilterQtyAction(this.filter_qty_action);
            this.setCategoryId(this.category_id);
            this.setCategoryLink(this.category_link);
        },
        methods: {
            ...mapMutations({
                setRequestParameters: 'CatalogFilter/setRequestParameters',
                setFilterQtyAction: 'CatalogFilter/setFilterQtyAction',
                setCategoryId: 'CatalogFilter/setCategoryId',
                setCategoryLink: 'CatalogFilter/setCategoryLink',
            })
        }
    }
</script>
