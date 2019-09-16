<template>
    <select v-model="product.quantity" class="form-control" @change="changeQuantity">
        <option :value="index+1" v-for="(option, index) in product.product.quantity" v-text="index+1"></option>
    </select>
</template>
<script>
    export default {
        props: ['product', 'action', 'item_quantity'],

        data() {
            return {
                // productItemQuantity: this.product.quantity,
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
            }
        },
        // created() {
        //     this.productItemQuantity = this.product.quantity;
        // },
        methods: {
            changeQuantity() {
                if(this.productItemQuantity != this.product.quantity) {

                    var self = this;
                    let form = new FormData();
                    form.append('quantity', this.product.quantity);
                        axios.post(this.action, form)
                            .catch(error => {
                                alert(error.response.data.message);
                            })
                            .then(data => {
                                this.$emit('productQuantityChanged', data.data)
                            })
                }
            }
        }
    }
</script>
