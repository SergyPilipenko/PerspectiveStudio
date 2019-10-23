<template>
    <div>
        hello
    </div>
</template>

<script>
    import TextBlock from "./TextBlock";
    import {mapMutations} from 'vuex'
    export default {
        components: {TextBlock},

        created() {
            this.setRequestParameters();
        },
        methods: {
            ...mapMutations({
                setRequestParameters: 'CatalogFilter/setRequestParameters'
            })
        }
    }
</script>
