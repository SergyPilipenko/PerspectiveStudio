<template>
    <div>
        <div v-if="cart.cart_items.length">
            <ul>
                <li v-for="item in cart.cart_items">
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
                        <form :action="'/cart/change-item-quantity/'+item.id" method="POST" style="display: flex !important; flex-direction: row !important;">
                            <input type="hidden" name="_token" :value="token">
                            <input type="hidden" name="_method" value="put">
                            <input type="number" min="1" name="quantity" :value="item.quantity">
                            <button class="btn btn-sm btn-primary">submit</button>
                        </form>

                    </div>
                    <div style="margin-top: 20px">
                        <form :action="'/cart/remove-cart-item/'+item.id" method="POST">
                            <input type="hidden" name="_token" :value="token">
                            <input type="hidden" name="_method" value="delete">
                            <button class="btn btn-sm btn-danger">remove</button>
                        </form>
                    </div>
                </li>

            </ul>
            <H6>
                Cart total:
                {{ cart.grand_total }}
            </H6>
        </div>
        <div v-else>
            cart is empty
        </div>
    </div>
</template>
<script>
    export default {
        props: ['app_cart', 'destroy'],

        data() {
            return {
                cart: null,
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
            }
        },
        created() {
            this.cart = JSON.parse(this.app_cart);
        }

    }
</script>
