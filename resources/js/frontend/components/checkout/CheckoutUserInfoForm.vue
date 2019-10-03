<template>
    <div class="checkout__block">
        <h2 class="checkout__title">
            Оформление заказа
        </h2>
        <div class="d-flex">
            <button class="new">Я новый покупатель</button>
            <button class="constant">Я постоянный клиент</button>
        </div>
        <div class="checkout__input">
            <p>Телефон</p>
            <div class="d-flex align-items-center">
                <input type="text" name="phone" id="phone" @input="updatePhone">
                <span>Ошибка: Введите имя</span>
            </div>
        </div>
        <div class="checkout__input">
            <p>Имя</p>
            <div class="d-flex align-items-center">
                <input type="text" name="name" id="name" @input="updateName">
                <span>Ошибка: Введите имя</span>
            </div>
        </div>
        <div class="checkout__input">
            <p>Фамилия</p>
            <div class="d-flex align-items-center">
                <input type="text" name="last_name" id="last_name" @input="updateLastName">
                <span>Ошибка: Введите имя</span>
            </div>
        </div>
        <div class="checkout__input">
            <p>E-mail</p>
            <div class="d-flex align-items-center">
                <input type="text" name="email" id="email" @input="updateEmail">
                <span>Ошибка: Введите имя</span>
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

    export default {
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
