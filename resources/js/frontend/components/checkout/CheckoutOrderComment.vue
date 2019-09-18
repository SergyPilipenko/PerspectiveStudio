<template>
    <div class="col-md-8">
        <div>
            <label for="order_comment" class="text-danger" id="order_comment_label" @click="showForm">Комментарий к заказу</label>
            <textarea class="form-control" name="order_comment" id="order_comment" v-if="show" @input="updateOrderComment"></textarea>
        </div>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        data() {
            return {
                show: false
            }
        },
        computed: {
            ...mapGetters({
                'getOrderComment': 'Checkout/getOrderComment',
            })
        },
        methods: {
            ...mapMutations({
                'setOrderComment': 'Checkout/setOrderComment',
            }),
            showForm() {
                this.show = !this.show;
            },
            updateOrderComment(e) {
                this.setOrderComment(e.target.value);
            }
        }
    }
</script>

<style>
    #order_comment_label {
        cursor: pointer;
        border-bottom: 1px dashed red;
    }
</style>
