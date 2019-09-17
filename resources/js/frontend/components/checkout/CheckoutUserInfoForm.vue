<template>
    <div>
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" name="phone" class="form-control" id="phone" @input="updatePhone">
            <span v-if="errors && errors.phone"></span>
        </div>
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" name="name" class="form-control" id="name" @input="updateName">
            <span v-if="errors && errors.name" v-text="errors.name"></span>
        </div>
        <div class="form-group">
            <label for="last_name">Фамилия</label>
            <input type="text" name="last_name" class="form-control" id="last_name" @input="updateLastName">
            <span v-if="errors && errors.last_name" v-text="errors.last_name" ></span>
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" class="form-control" id="email" @input="updateEmail">
            <span v-if="errors && errors.email" v-text="errors.email"></span>
        </div>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        data() {
            return {
                errors: null,
                phone: "",
                name: "",
                last_name: "",
                email: "",
            }
        },
        computed: {
            ...mapGetters({
                'getName': 'Checkout/getName',
                'getLastName': 'Checkout/getLastName',
                'getPhone': 'Checkout/getPhone',
                'getEmail': 'Checkout/getEmail',
            })
        },
        methods: {
            ...mapMutations({
                'setName': 'Checkout/setName',
                'setPhone': 'Checkout/setPhone',
                'setLastName': 'Checkout/setLastName',
                'setEmail': 'Checkout/setEmail',
            }),
            updateName(e) {
                this.setName(e.target.value);
            },
            updatePhone(e) {
                this.setPhone(e.target.value);
            },
            updateLastName(e) {
                this.setLastName(e.target.value);
            },
            updateEmail(e) {
                this.setEmail(e.target.value);
            }
        }
    }
</script>
