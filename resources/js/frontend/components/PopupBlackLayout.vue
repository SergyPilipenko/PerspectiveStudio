<template>
    <div class="popup-black2 d-block layout" @click="hidePopupLayout" v-if="getPopupLayout"></div>
</template>
<script>
    import {mapGetters, mapMutations} from 'vuex'

    export default {
        computed: {
            ...mapGetters({
                'getPopupLayout': 'General/getPopupLayout',
            }),
        },
        methods: {
            ...mapMutations({
                'hidePopupLayout': 'General/hidePopupLayout'
            })
        }
    }
</script>
