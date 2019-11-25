<template>
    <div>

    </div>
</template>

<script>
    import TextBlock from "./TextBlock";
    import DecimalBlock from "./DecimalBlock";
    import PreloadLayout from "./PreloadLayout";
    import AppliedFilters from "./AppliedFilters";
    import { mapMutations, mapGetters, mapActions } from 'vuex';

    export default {
        components: { TextBlock, PreloadLayout, DecimalBlock, AppliedFilters },
        props: ['filter_qty_action', 'category_id', 'category_link', 'modification'],

        created() {
            this.setRequestParameters();
            this.setFilterQtyAction(this.filter_qty_action);
            this.setCategoryId(this.category_id);
            this.setCategoryLink(this.category_link);
            if(this.modification) {
                
                this.setModification(this.modification);
            }
        },
        mounted() {
            this.setAppliedFilters();
        },
        computed: {
            ...mapGetters({
                getRequestParams: 'CatalogFilter/getRequestParams'
            })
        },
        methods: {
            ...mapMutations({
                setRequestParameters: 'CatalogFilter/setRequestParameters',
                setFilterQtyAction: 'CatalogFilter/setFilterQtyAction',
                setCategoryId: 'CatalogFilter/setCategoryId',
                setCategoryLink: 'CatalogFilter/setCategoryLink',
                setModification: 'CatalogFilter/setModification',
            }),
            ...mapActions({
                setAppliedFilters: 'CatalogFilter/setAppliedFilters',
            })
        }
    }
</script>
