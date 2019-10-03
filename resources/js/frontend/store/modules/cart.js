export default {
    namespaced: true,
    state: {
        cart: null
    },
    getters: {
        getCart(state) {
            return state.cart;
        },
        getCartTotal(state) {
            return state.cart ? state.cart.grand_total : null
        },
    },
    mutations: {
        setCart(state, newValue) {
            state.cart = newValue;
        },
    },
    actions: {

    }
}
