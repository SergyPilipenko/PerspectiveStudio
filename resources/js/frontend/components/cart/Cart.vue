<template>
    <div>
        <div v-if="getCart.cart_items.length">
            <ul>
                <li v-for="item in getCart.cart_items">
                    <ul>
                        <li>
                            <strong>
                                name:
                                {{ item.product.name }}
                            </strong>
                        </li>
                        <li>
                            article:
                            {{ item.product.article }}
                        </li>
                        <li>
                            quantity:
                            {{ item.quantity }}
                        </li>
                        <li>
                            price:
                            {{ item.price }}
                        </li>
                        <li>
                            total:
                            {{ item.total }}
                        </li>
                    </ul>
                    <div >
                        <change-product-quantity-in-cart
                            :product="item" :action="'/cart/change-item-quantity/'+item.id"
                            @productQuantityChanged="productQuantityChanged"
                            :key="item.id"
                        >

                        </change-product-quantity-in-cart>

<!--                        <form :action="'/cart/change-item-quantity/'+item.id" method="POST" style="display: flex !important; flex-direction: row !important;">-->

<!--                            <input type="hidden" name="_token" :value="token">-->
<!--                            <input type="hidden" name="_method" value="put">-->
<!--                            <input type="number" min="1" name="quantity" :value="item.quantity">-->
<!--                            <button class="btn btn-sm btn-primary">submit</button>-->
<!--                        </form>-->
                    </div>
                    <div style="margin-top: 20px">
                        <delete-product-from-cart-form
                            :action="'/cart/remove-cart-item/'+item.id"
                            @productDeleted="productDeleted"
                            :key="item.id"
                        ></delete-product-from-cart-form>
                    </div>
                </li>

            </ul>
            <h6>
                Cart total:
                {{ getCart.grand_total }}
            </h6>
            <h6>
                Cart items count:
                {{ getCart.items_count }}
            </h6>
        </div>
        <div v-else>
            cart is empty
        </div>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'
    import ChangeProductQuantityInCart from "./ChangeProductQuantityInCart";
    import DeleteProductFromCartForm from "./DeleteProductFromCartForm";

    export default {

        props: ['app_cart', 'destroy'],
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
            }),
            options() {
                console.log();
            }
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
            }
        }

    }
</script>
