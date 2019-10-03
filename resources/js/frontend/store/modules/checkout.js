export default {
    namespaced: true,
    state: {
        cartId: null,
        submitAction: "",
        cartTotal: 0,
        deliveryPrice: 0,
        orderTotal: 0,
        bonuses: 0,
        name: "",
        phone: "",
        email: "",
        lastName: "",
        orderComment: "",
        errors: []
    },
    getters: {
        getCartId(state) {
            return state.cartId
        },
        getSubmitAction(state) {
            return state.submitAction
        },
        getCartTotal(state) {
            return parseFloat(state.cartTotal)
        },
        getCartTotalFloat(state) {
            return parseFloat(state.cartTotal).toFixed(2)
        },
        getDeliveryPriceFloat(state) {
            return parseFloat(state.deliveryPrice).toFixed(2)
        },
        getDeliveryPrice(state) {
            return parseFloat(state.deliveryPrice)
        },
        getBonuses(state) {
            return parseFloat(state.bonuses)
        },
        getBonusesFloat(state) {
            return parseFloat(state.bonuses).toFixed(2)
        },
        getOrderTotal(state) {
            return parseFloat(state.orderTotal).toFixed(2)
        },
        getName(state) {
            return state.name
        },
        getLastName(state) {
            return state.lastName
        },
        getEmail(state) {
            return state.email
        },
        getPhone(state) {
            return state.phone
        },
        getOrderComment(state) {
            return state.orderComment
        },
        getErrors(state) {
            return state.errors
        }
    },
    mutations: {
        setCartId(state, newValue) {
            state.cartId = newValue;
        },
        setCartTotal(state, newValue) {
            state.cartTotal = newValue;
        },
        setOrderTotal(state, newValue) {
            state.orderTotal = newValue;
        },
        setName(state, newValue) {
            state.name = newValue
        },
        setLastName(state, newValue) {
            state.lastName = newValue
        },
        setPhone(state, newValue) {
            state.phone = newValue
        },
        setEmail(state, newValue) {
            state.email = newValue
        },
        setOrderComment(state, newValue) {
            state.orderComment = newValue
        },
        setSubmitAction(state, newValue) {
            state.submitAction = newValue
        },
        setErrors(state, newValue) {
            state.errors = newValue
        },
        resetErrors(state) {
            state.errors = []
        }
    },
    actions: {
        refreshOrderTotal(context, payload) {
            var getters = context.getters;
            var total = getters.getCartTotal + getters.getDeliveryPrice - getters.getBonuses;
            context.commit('setOrderTotal', total.toFixed(4));
        },
        setCartTotal(context, payload) {
            context.commit('setCartTotal', payload);
            context.dispatch('refreshOrderTotal', payload);
        },
        clearFieldErrors(context, payload) {
            var errors = context.getters.getErrors;
            if(errors.errors != undefined && errors.errors[payload] != undefined) {
                delete errors.errors[payload];
                context.commit('setErrors', JSON.parse(JSON.stringify(errors)));
            }
        },
        orderSubmit({commit, getters}, payload) {
            var form = new FormData()
            var phone = getters.getPhone;
            form.append('customer_first_name', getters.getName);
            form.append('customer_last_name', getters.getLastName);
            form.append('customer_phone', phone.replace(/\D+/g, ''));
            form.append('customer_email', getters.getEmail);
            form.append('cart_id', getters.getCartId);
            form.append('order_comment', getters.getOrderComment);
            axios.post(getters.getSubmitAction, form)
                .catch(error => {
                        console.log(error.response.data);
                        commit('setErrors', error.response.data);
                        if(error.response.data.message) {
                            alert(error.response.data.message);
                        }
                })
                .then(data => {
                    if(data) {
                        commit('resetErrors')
                        if(data.data == "success") {
                            alert('Заказ был сохранен успешно');
                            window.location.href = "/";
                        };
                    }
                });
        }
    }
}
