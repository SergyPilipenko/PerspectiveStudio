<template>
    <select v-model="product.quantity" class="form-control" @change="changeQuantity">
        <option :value="index+1" v-for="(option, index) in qty" v-text="index+1"></option>
    </select>
</template>
<script>
    export default {
        props: ['product', 'action', 'item_quantity'],

        data() {
            return {
                productItemQuantity: this.product.quantity,
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
            }
        },

        computed: {
            qty() {
                if(this.productItemQuantity <= this.product.quantity && this.product.quantity < 30) {
                    this.productItemQuantity = 30;
                    return this.productItemQuantity;
                }else if(this.productItemQuantity <= this.product.quantity && this.product.quantity >= 30)  {
                    this.productItemQuantity = this.product.quantity;
                    return this.productItemQuantity
                } else  {
                    // this.productItemQuantity = 30;
                    return this.productItemQuantity;
                }
            }
        },
        // created() {
        //     this.productItemQuantity = this.product.quantity;
        // },
        methods: {
            changeQuantity() {
                    var self = this;
                    let form = new FormData();
                    form.append('quantity', this.product.quantity);
                        axios.post(this.action, form)
                            .catch(error => {
                                alert(error.response.data.message);
                            })
                            .then(data => {
                                this.$emit('productQuantityChanged', data.data);
                            });
            },
            maxQuantity(qty) {
                if(qty > this.productItemQuantity) {
                    this.productItemQuantity = this.product.quantity;
                }
            }
        }
    }
</script>
