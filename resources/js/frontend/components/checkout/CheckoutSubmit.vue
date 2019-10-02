<template>
    <div>
        <button type="button" class="btn btn-block btn-success" @click="orderSubmit">Заказ подтверждаю</button>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        methods: {
            ...mapActions({
                'orderSubmit': 'Checkout/orderSubmit'
            })
        }
    }
</script>
