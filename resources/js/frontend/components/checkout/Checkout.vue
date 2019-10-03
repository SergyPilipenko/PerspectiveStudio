<template>
    <section class="checkout">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <slot name="content"></slot>
                </div>
            </div>
        </div>
    </section>

    <!--    <div class="col-md-12">-->
<!--        <slot name="content" v-if="getCart && getCart.cart_items.length"></slot>-->
<!--        <div v-else>-->
<!--            your cart is empty :(-->
<!--            <a href="/">go shopping</a>-->
<!--        </div>-->
<!--    </div>-->
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        props: ['app_cart'],

        created() {
            if(this.app_cart && !this.getCart) {
                this.setCart(JSON.parse(this.app_cart));
            }
        },
        computed: {
            ...mapGetters({
                'getCart': 'Cart/getCart',
                'getCartTotal': 'Cart/getCartTotal',

            })
        },
        methods: {
            ...mapMutations({
                'setCart': 'Cart/setCart'
            }),
            ...mapActions({
                'setCheckoutCartTotal': 'Checkout/setCartTotal',
            }),
        },
        watch: {
            getCartTotal(newValue, oldValue) {
                this.setCheckoutCartTotal(newValue);
            }
        }
    }
</script>
