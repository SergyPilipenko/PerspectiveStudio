<template>
    <div class="checkout__sidebar" v-if="getCart">
        <h2 class="checkout__title">
            Ваш заказ
        </h2>
        <div class="header__cart-dropdown-item" v-for="product in getCart.cart_items">
            <img src="/img/frontend/img/cart-item.png" alt="cart-item" class="header__cart-dropdown-item-img">
            <div class="d-flex flex-column">
                <a :href="product.product.path" class="header__cart-dropdown-title" v-text="product.name"></a>
                <span class="header__cart-dropdown-code" v-text="'Артикул: ' + product.article"></span>
                <span class="header__cart-dropdown-company" v-text="product.product.manufacturer"></span>

                <div class="d-flex align-items-center">
                    <change-product-quantity-in-cart
                        :product="product" :action="'/cart/change-item-quantity/'+product.id"
                        @productQuantityChanged="productQuantityChanged"
                        :key="product.id"
                    >
                    </change-product-quantity-in-cart>
                    <span class="header__cart-dropdown-price" v-text="product.base_total + ' грн'"></span>
                </div>
            </div>
            <delete-product-from-cart-form
                :action="'/cart/remove-cart-item/'+product.id"
                @productDeleted="productDeleted"
                :key="product.id"
            ></delete-product-from-cart-form>
        </div>
        <div class="checkout__promo">
            <div class="d-flex align-items-center mb10">
                <img src="/img/frontend/img/svg/speech-bubble.svg" alt="speech-bubble">
                <a href="#">Ввести промокод</a>
                <img src="/img/frontend/img/svg/info.svg" alt="info">
            </div>
            <div class="d-flex align-items-center mb10">
                <img src="/img/frontend/img/svg/info.svg" alt="info">
                <a href="#">Ввести номер счета</a>
                <img src="/img/frontend/img/svg/info.svg" alt="info">
            </div>
        </div>
        <div class="d-flex justify-content-between checkout__info">
            <span>Сумма:</span><span v-text="getCartTotalFloat + ' грн'"></span>
        </div>
        <div class="d-flex justify-content-between checkout__info" v-if="getDeliveryPrice">
            <span>Доставка:</span><span v-text="getDeliveryPriceFloat + ' грн'"></span>
        </div>
        <div class="d-flex justify-content-between checkout__info" v-if="getBonuses">
            <span>Бонусы:</span><span v-text="'-' + getBonuses + ' грн'"></span>
        </div>
        <div class="d-flex justify-content-between checkout__info checkout__info-total">
            <span>Итого к оплате:</span><span v-text="getOrderTotal + ' грн'"></span>
        </div>
        <checkout-submit></checkout-submit>
        <div class="d-flex align-items-center justify-content-center flex-column">
            <span class="checkout__bonus">56 гривен</span>
            <p class="checkout__delivery-info text-center">будет начислено на ваш бонусный счёт<br/>
                при условии успешной покупки</p>
            <a href="#" class="checkout__link">Подробнее</a>
        </div>
    </div>
<!--    <div v-if="getCart">-->

<!--        <strong>Ваш заказ</strong>-->
<!--        <div style="border-bottom: 1px solid red; padding-bottom: 20px">-->
<!--            <div v-for="product in getCart.cart_items">-->
<!--                <div v-if="product.product.images.length">-->
<!--                    <img style="max-width: 100px" :src="'/'+product.product.images[0].path" alt="">-->
<!--                </div>-->
<!--                <div v-else>-->
<!--                    empty image-->
<!--                </div>-->
<!--                <a :href="product.product.path">-->
<!--                    <p v-text="product.product.name"></p>-->
<!--                </a>-->
<!--                <p>Артикул: {{ product.article }}</p>-->
<!--                <div>-->
<!--                    <change-product-quantity-in-cart-->
<!--                        :product="product" :action="'/cart/change-item-quantity/'+product.id"-->
<!--                        @productQuantityChanged="productQuantityChanged"-->
<!--                        :key="product.id"-->
<!--                    >-->
<!--                    </change-product-quantity-in-cart>-->
<!--                </div>-->
<!--                <p v-text="product.total"></p>-->
<!--                <div style="margin-top: 20px">-->
<!--                    <delete-product-from-cart-form-->
<!--                        :action="'/cart/remove-cart-item/'+product.id"-->
<!--                        @productDeleted="productDeleted"-->
<!--                        :key="product.id"-->
<!--                    ></delete-product-from-cart-form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div>-->
<!--            <div>Сумма: {{ getCartTotalFloat }} грн</div>-->
<!--            <div>Доставка: {{ getDeliveryPriceFloat }} грн</div>-->
<!--            <div v-if="getBonuses">Бонусы: -{{ getBonusesFloat }} грн</div>-->
<!--            <div>-->
<!--                <h6><strong>Итого к оплате: {{ getOrderTotal }} грн</strong></h6>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div>-->
<!--            <checkout-submit></checkout-submit>-->
<!--        </div>-->
<!--    </div>-->
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'
    import ChangeProductQuantityInCart from "../cart/ChangeProductQuantityInCart"
    import DeleteProductFromCartForm from "../cart/DeleteProductFromCartForm"
    import CheckoutSubmit from "./CheckoutSubmit";

    export default {
        props: ['app_cart', 'save_order_action'],
        components: {
            ChangeProductQuantityInCart,
            DeleteProductFromCartForm,
            CheckoutSubmit
        },
        data() {
            return {
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
            }
        },
        created() {
            if(this.app_cart) {
                if(!this.getCart) {
                    this.setCart(JSON.parse(this.app_cart));
                }
                this.setCartId(this.getCart.id);
                this.setSubmitAction(this.save_order_action)
            }
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
                'setCheckoutCartTotal': 'Checkout/setCartTotal',
            }),
            ...mapMutations({
                'setCart': 'Cart/setCart',
                'setCartId': 'Checkout/setCartId',
                'setSubmitAction': 'Checkout/setSubmitAction',
            }),
            productQuantityChanged(cart) {
                this.setCart(cart);
            },
            productDeleted(cart) {
                this.setCart(cart);
            },
        }
    }
</script>
