export default {
    namespaced: true,
    state: {
        cartTotal: 0,
        deliveryPrice: 0,
        orderTotal: 0,
        bonuses: 0,
        name: "",
        phone: "",
        email: "",
        last_name: "",
    },
    getters: {
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
            return state.last_name
        },
        getEmail(state) {
            return state.email
        },
        getPhone(state) {
            return state.phone
        },
    },
    mutations: {
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
            state.last_name = newValue
        },
        setPhone(state, newValue) {
            state.phone = newValue
        },
        setEmail(state, newValue) {
            state.email = newValue
        },
    },
    actions: {
        refreshOrderTotal: function(context, payload) {
            var getters = context.getters;
            var total = getters.getCartTotal + getters.getDeliveryPrice - getters.getBonuses;
            context.commit('setOrderTotal', total.toFixed(4));
        },
        setCartTotal: function (context, payload) {
            context.commit('setCartTotal', payload);
            context.dispatch('refreshOrderTotal', payload);
        },
        // updateName: function (context, payload) {
        //     context.commit('setName', payload)
        // }
    }
}
