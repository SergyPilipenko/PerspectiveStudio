<template>
    <div>
        <strong>Ваш заказ</strong>
        <div style="border-bottom: 1px solid red; padding-bottom: 20px">
            <div v-for="product in getCart.cart_items">
                <div v-if="product.product.images.length">
                    <img style="max-width: 100px" :src="'/'+product.product.images[0].path" alt="">
                </div>
                <div v-else>
                    empty image
                </div>
                <a :href="product.product.path">
                    <p v-text="product.product.name"></p>
                </a>
                <p>Артикул: {{ product.article }}</p>
                <div>
                    <change-product-quantity-in-cart
                        :product="product" :action="'/cart/change-item-quantity/'+product.id"
                        @productQuantityChanged="productQuantityChanged"
                        :key="product.id"
                    >
                    </change-product-quantity-in-cart>
                </div>
                <p v-text="product.total"></p>
                <div style="margin-top: 20px">
                    <delete-product-from-cart-form
                        :action="'/cart/remove-cart-item/'+product.id"
                        @productDeleted="productDeleted"
                        :key="product.id"
                    ></delete-product-from-cart-form>
                </div>
            </div>
        </div>
        <div>
            <div>Сумма: {{ getCartTotalFloat }} грн</div>
            <div>Доставка: {{ getDeliveryPriceFloat }} грн</div>
            <div v-if="getBonuses">Бонусы: -{{ getBonusesFloat }} грн</div>
            <div>
                <h6><strong>Итого к оплате: {{ getOrderTotal }} грн</strong></h6>
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-block btn-success">Заказ подтверждаю</button>
        </div>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'
    import ChangeProductQuantityInCart from "../cart/ChangeProductQuantityInCart";
    import DeleteProductFromCartForm from "../cart/DeleteProductFromCartForm";

    export default {
        props: ['app_cart'],
        components: {
            ChangeProductQuantityInCart,
            DeleteProductFromCartForm
        },
        data() {
            return {
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
            }
        },
        created() {
            this.setCart(JSON.parse(this.app_cart));
        },
        computed: {
            ...mapGetters({
                'getCart': 'Cart/getCart',
                'getCartTotal': 'Cart/getCartTotal',
                'getDeliveryPrice': 'Checkout/getDeliveryPrice',
                'getOrderTotal': 'Checkout/getOrderTotal',
                'getDeliveryPriceFloat': 'Checkout/getDeliveryPriceFloat',
                'getBonusesFloat': 'Checkout/getBonusesFloat',
                'getCartTotalFloat': 'Checkout/getCartTotalFloat',
                'getBonuses': 'Checkout/getBonuses'
            })
        },
        methods: {
            ...mapActions({
                'setCheckoutCartTotal': 'Checkout/setCartTotal'
            }),
            ...mapMutations({
                'setCart': 'Cart/setCart',
            }),
            productQuantityChanged(cart) {
                this.setCart(cart);
            },
            productDeleted(cart) {
                this.setCart(cart);
            },
        },
        watch: {
            getCartTotal(newValue, oldValue) {
                this.setCheckoutCartTotal(newValue);
            }
        }
    }
</script>
