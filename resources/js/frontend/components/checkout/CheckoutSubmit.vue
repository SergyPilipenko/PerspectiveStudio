<template>
    <div>
        <button type="submit" class="checkout__submit" @click="orderSubmit">Заказ подтверждаю</button>
    </div>
</template>
<script>
    import { mapActions } from 'vuex'

    export default {
        methods: {
            ...mapActions({
                'orderSubmit': 'Checkout/orderSubmit'
            })
        }
    }
</script>
