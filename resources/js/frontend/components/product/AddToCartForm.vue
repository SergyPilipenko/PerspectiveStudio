<template>
    <form :action="action" method="POST" @submit.prevent="addProduct">
        <input type="hidden" name="_token" :value="token">
        <input type="hidden" name="product" :value="product.id">
        <input type="hidden" name="quantity" :value="1">
        <button class="btn btn-primary">Add to cart</button>
    </form>
</template>
<script>
    export default {
        props: ['product', 'action'],
        data() {
            return {
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
            }
        },
        methods: {
            addProduct() {
                var self = this;
                let form = new FormData();
                form.append('product', this.product.id);
                form.append('quantity', 1);
                axios.post(this.action, form)
                    .catch(error => {
                        alert(error.response.data.message);
                    })
                    .then(data => {
                        console.log(data);
                        this.$emit('productAdded', data.data)
                        // self.addBodyTypes(data.data);
                    })
            }
        }
    }
</script>
