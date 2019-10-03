<template>
    <div class="checkout__block">
        <h2 class="checkout__title">
            Оформление заказа
        </h2>
        <div class="d-flex">
            <button class="new">Я новый покупатель</button>
            <button class="constant">Я постоянный клиент</button>
        </div>
        <div :class="{'checkout__input invalid' : isInvalid('customer_phone'), 'checkout__input' : !isInvalid('customer_phone')}">
            <p>Телефон</p>
            <div class="d-flex align-items-center">
                <input type="tel" name="phone" id="phone" @input="updatePhone" v-mask="'+38 (0##) ### ## ##'" masked="true">
                <div v-if="getErrors.errors && getErrors.errors.customer_phone">
                    <div v-for="error in getErrors.errors.customer_phone">
                        <span>Ошибка: Введите номер телефона</span>
                    </div>
                </div>
            </div>
        </div>
        <div :class="{'checkout__input invalid' : isInvalid('customer_first_name'), 'checkout__input' : !isInvalid('customer_first_name')}">
            <p>Имя</p>
            <div class="d-flex align-items-center">
                <input type="text" name="name" id="name" @input="updateName">
                <span>Ошибка: Введите имя</span>
            </div>
        </div>
        <div :class="{'checkout__input invalid' : isInvalid('customer_last_name'), 'checkout__input' : !isInvalid('customer_last_name')}">
            <p>Фамилия</p>
            <div class="d-flex align-items-center">
                <input type="text" name="last_name" id="last_name" @input="updateLastName">
                <span>Ошибка: Введите фамилию</span>
            </div>
        </div>
        <div :class="{'checkout__input invalid' : isInvalid('customer_email'), 'checkout__input' : !isInvalid('customer_email')}">
            <p>E-mail</p>
            <div class="d-flex align-items-center">
                <input type="text" name="email" id="email" @input="updateEmail">
                <span>Ошибка: Введите email</span>
            </div>
            <span class="email">Пожалуйста, заполните e-mail для отслеживания статуса заказа</span>
        </div>
    </div>
<!--    <div>-->
<!--        <div class="form-group">-->
<!--            <label for="phone">Телефон</label>-->
<!--            <input type="text" name="phone" class="form-control" id="phone" @input="updatePhone">-->
<!--            <div v-if="getErrors.errors && getErrors.errors.customer_phone">-->
<!--                <div v-for="error in getErrors.errors.customer_phone">-->
<!--                    <div v-text="error"></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="name">Имя</label>-->
<!--            <input type="text" name="name" class="form-control" id="name" @input="updateName">-->
<!--            <div v-if="getErrors.errors && getErrors.errors.customer_first_name">-->
<!--                <div v-for="error in getErrors.errors.customer_first_name">-->
<!--                    <div v-text="error"></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="last_name">Фамилия</label>-->
<!--            <input type="text" name="last_name" class="form-control" id="last_name" @input="updateLastName">-->
<!--            <div v-if="getErrors.errors && getErrors.errors.customer_last_name">-->
<!--                <div v-for="error in getErrors.errors.customer_last_name">-->
<!--                    <div v-text="error"></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="email">E-mail</label>-->
<!--            <input type="email" name="email" class="form-control" id="email" @input="updateEmail">-->
<!--            <div v-if="getErrors.errors && getErrors.errors.customer_email">-->
<!--                <div v-for="error in getErrors.errors.customer_email">-->
<!--                    <div v-text="error"></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'
    import {TheMask} from 'vue-the-mask'

    export default {
        components: {TheMask},
        data() {
            return {
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
                'getErrors': 'Checkout/getErrors',
            })
        },
        methods: {
            ...mapMutations({
                'setName': 'Checkout/setName',
                'setPhone': 'Checkout/setPhone',
                'setLastName': 'Checkout/setLastName',
                'setEmail': 'Checkout/setEmail',
            }),
            ...mapActions({
                'clearFieldErrors': 'Checkout/clearFieldErrors'
            }),
            updateName(e) {
                this.clearFieldErrors('customer_first_name');
                this.setName(e.target.value);
            },
            updatePhone(e) {
                this.clearFieldErrors('customer_phone');
                this.setPhone(e.target.value);
            },
            updateLastName(e) {
                this.clearFieldErrors('customer_last_name');
                this.setLastName(e.target.value);
            },
            updateEmail(e) {
                this.clearFieldErrors('customer_email');
                this.setEmail(e.target.value);
            },
            isInvalid(inputName) {
                var errors = this.getErrors.errors;
                if(errors != undefined && errors[inputName] != undefined) {
                    return true;
                }

                return false;
            }
        }
    }
</script>
