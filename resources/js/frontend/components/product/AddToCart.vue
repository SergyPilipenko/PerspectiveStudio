<template>
    <div class="d-flex align-items-center">
        <select v-model="selectedQuantity"  class="form-control" v-if="quantity_select == 'true'">
            <option v-for="(option, index) in quantity" v-text="option"></option>
        </select>
        <div @click="addProduct">
            <slot name="button"></slot>
        </div>
    </div>
</template>
<script>
    import { mapMutations } from 'vuex'

    export default {
        props: ['product', 'action', 'quantity_select'],
        data() {
            return {
                quantity: 30,
                selectedQuantity: 1,
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
                currentProduct: []
            }
        },
        created() {
            this.currentProduct = JSON.parse(this.product);
        },
        methods: {
            ...mapMutations({
                'setCart': 'Cart/setCart'
            }),

            addProduct() {
                var self = this;
                let form = new FormData();
                form.append('product', this.currentProduct.id);
                form.append('quantity', this.selectedQuantity);
                axios.post(this.action, form)
                    .catch(error => {
                        alert(error.response.data.message);
                    })
                    .then(data => {
                        this.setCart(data.data);
                    })
            }
        }
    }
</script>
