<template>
    <form :action="action" method="POST" @submit.prevent="deleteProduct">
        <input type="hidden" name="_method" value="delete">
        <button class="header__cart-dropdown-item-delete"><img src="img/frontend/img/trash.png" alt="trash"></button>
<!--        <button class="btn btn-sm btn-danger">remove</button>-->
    </form>
</template>
<script>
    export default {
        props: ['action', 'product'],

        data() {
            return {
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
            }
        },
        methods: {
            deleteProduct() {
                var self = this;
                let form = new FormData();
                axios.delete(this.action, form)
                    .catch(error => {
                        alert(error.response.data.message);
                    })
                    .then(data => {
                        this.$emit('productDeleted', data.data)
                        // self.addBodyTypes(data.data);
                    })
            }
        }
    }
</script>
