<template>
    <form :action="action" method="POST" @submit.prevent="addProduct" >
        <select v-model="selectedQuantity"  class="form-control" v-if="!hideSelect">
            <option v-for="(option, index) in quantity" v-text="option"></option>
        </select>
        <input type="hidden" name="_token" :value="token">
        <input type="hidden" name="product" :value="product.id">
        <input type="hidden" name="quantity" :value="1">
        <button class="last-goods__buy">Купить</button>
    </form>
</template>
<script>
    export default {
        props: ['product', 'action', 'hideSelect'],
        data() {
            return {
                quantity: 30,
                selectedQuantity: 1,
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
            }
        },
        methods: {
            addProduct() {
                var self = this;
                let form = new FormData();
                form.append('product', this.product.id);
                form.append('quantity', this.selectedQuantity);
                axios.post(this.action, form)
                    .catch(error => {
                        alert(error.response.data.message);
                    })
                    .then(data => {
                        this.$emit('productAdded', data.data)
                    })
            }
        }
    }
</script>
