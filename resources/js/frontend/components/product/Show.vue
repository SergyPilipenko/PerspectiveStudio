<template>
    <div>
        <h1 v-text="getProduct.custom_attributes.name"></h1>
        <div>
            <div>
                <div>
                    артикул: {{ getProduct.article }}
                </div>
                <div v-if="getProduct.price > 0">
                    цена: {{ getProduct.price }}
                </div>
                <div>
                    {{ getProduct.custom_attributes.short_description }}
                </div>
                <div>
                    {{ getProduct.custom_attributes.description }}
                </div>
                <img  v-if="getProduct.images.length" style="max-width: 100px" :src="'/'+image.path" alt="" v-for="image in getProduct.images">
            </div>
        </div>
        <add-to-cart-form :product="getProduct" :action="add_action" @productAdded="refreshCart" v-if="getProduct.price > 0"></add-to-cart-form>
        <div v-else>
            <button type="button" disabled class="btn btn-secondary">Нет в наличии</button>
        </div>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    import AddToCartForm from "./AddToCartForm";

    export default {
        props: ['product', 'add_action'],
        components: {
            AddToCartForm
        },
        data() {
            return {
                productData: null,
            }
        },
        created() {
            this.setProduct(JSON.parse(this.product));
        },
        computed: {
            ...mapGetters({
                'getProduct': 'productShow/getProduct',
            }),
        },
        methods: {
            ...mapMutations({
                'setProduct': 'productShow/setProduct',
                'setCart': 'Cart/setCart'
            }),
            refreshCart(cart) {
                this.setCart(cart);
            }
        }
    }
</script>
