<template>
    <div>
        <div class="header__punkt header__cart" @click="toggleCart">
            <img src="img/frontend/img/svg/shopping-bag2.svg" alt="shopping-bag2" class="icon">
            <span class="header__punkt-counter" v-if="getCart" v-text="getCart.items_qty"></span>
            <span class="header__punkt-counter" v-else>0</span>
            <span class="header__punkt-title">Корзина</span>
            <img src="img/frontend/img/arrow-down.png" alt="img" :class="{'arrow' : !show, 'arrow active' : show}">
        </div>
        <div class="header__cart-dropdown" v-if="show">
            <span class="close" @click="hideCart"><img src="img/frontend/img/cross.png" alt="img"></span>
            <div v-if="getCart && getCart.items_qty">
                <div class="header__cart-dropdown-item" v-for="item in getCart.cart_items">
                    <img src="img/frontend/img/cart-item.png" alt="cart-item" class="header__cart-dropdown-item-img">
                    <div class="d-flex flex-column">
                        <a href="#" class="header__cart-dropdown-title" v-text="item.name"></a>
                        <span class="header__cart-dropdown-code">Артикул: {{ item.article }}</span>
                        <span class="header__cart-dropdown-company">{{ item.product.manufacturer }}</span>
                        <div class="d-flex align-items-center">
                            <!--                                <div class="header__cart-dropdown-quantity">-->
                            <!--                                    <span>4 шт.</span>-->
                            <!--                                    <img src="img/frontend/img/arrow-down.png" alt="arrow">-->
                            <!--                                    <div>-->
                            <!--                                        <span>1 шт.</span>-->
                            <!--                                        <span>2 шт.</span>-->
                            <!--                                        <span>3 шт.</span>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <change-product-quantity-in-cart
                                :product="item" :action="'/cart/change-item-quantity/'+item.id"
                                @productQuantityChanged="productQuantityChanged"
                                :key="item.id"
                            >
                            </change-product-quantity-in-cart>
                            <span class="header__cart-dropdown-price">{{ parseFloat(item.base_price).toFixed(2) }} грн</span>
                        </div>
                    </div>
                    <delete-product-from-cart-form
                        :action="'/cart/remove-cart-item/'+item.id"
                        @productDeleted="productDeleted"
                        :key="item.id"
                    ></delete-product-from-cart-form>
                </div>
                <span class="header__cart-total">Итого: {{ parseFloat(getCart.grand_total).toFixed(2) }} грн</span>
                <div class="d-flex align-items-center justify-content-between header__cart-buttons">
                    <button class="header__cart-dropdown-continue" @click="hideCart">Продолжить покупки</button>
                    <button class="header__cart-dropdown-issue" @click="goToCheckout">Оформить заказ</button>
                </div>
            </div>
            <div v-else>Корзина пуста</div>
        </div>
<!--        <div v-if="getCart && getCart.cart_items.length">-->
<!--            <ul>-->
<!--                <li v-for="item in getCart.cart_items">-->
<!--                    <ul>-->
<!--                        <li>-->
<!--                            <strong>-->
<!--                                name:-->
<!--                                {{ item.product.name }}-->
<!--                            </strong>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            article:-->
<!--                            {{ item.product.article }}-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            quantity:-->
<!--                            {{ item.quantity }}-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            price:-->
<!--                            {{ item.price }}-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            total:-->
<!--                            {{ item.total }}-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                    <div>-->
<!--                        <change-product-quantity-in-cart-->
<!--                            :product="item" :action="'/cart/change-item-quantity/'+item.id"-->
<!--                            @productQuantityChanged="productQuantityChanged"-->
<!--                            :key="item.id"-->
<!--                        >-->
<!--                        </change-product-quantity-in-cart>-->
<!--                    </div>-->
<!--                    <div style="margin-top: 20px">-->
<!--                        <delete-product-from-cart-form-->
<!--                            :action="'/cart/remove-cart-item/'+item.id"-->
<!--                            @productDeleted="productDeleted"-->
<!--                            :key="item.id"-->
<!--                        ></delete-product-from-cart-form>-->
<!--                    </div>-->
<!--                </li>-->

<!--            </ul>-->
<!--            <h6>-->
<!--                Cart total:-->
<!--                {{ getCart.grand_total }}-->
<!--            </h6>-->
<!--            <h6>-->
<!--                Cart items count:-->
<!--                {{ getCart.items_count }}-->
<!--            </h6>-->
<!--            <a :href="checkout_link" class="btn btn-success">Checkout</a>-->
<!--        </div>-->
<!--        <div v-else>-->
<!--            cart is empty-->
<!--        </div>-->
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'
    import ChangeProductQuantityInCart from "./ChangeProductQuantityInCart";
    import DeleteProductFromCartForm from "./DeleteProductFromCartForm";

    export default {

        props: ['app_cart', 'destroy', 'checkout_link'],
        components: {
            ChangeProductQuantityInCart,
            DeleteProductFromCartForm
        },

        data() {
            return {
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
                show: false
            }
        },
        created() {
            if(this.app_cart) {
                this.setCart(JSON.parse(this.app_cart));
            }
        },
        computed: {
            ...mapGetters({
                'getCart': 'Cart/getCart',
            })
        },
        methods: {
            ...mapMutations({
                'setCart': 'Cart/setCart'
            }),
            productDeleted(cart) {
                this.setCart(cart);
            },
            productQuantityChanged(cart) {
                this.setCart(cart);
            },
            goToCheckout() {
                window.location.href = this.checkout_link
            },
            toggleCart() {
                this.show = !this.show;
            },
            hideCart() {
                this.show = false
            }
        }

    }
</script>
