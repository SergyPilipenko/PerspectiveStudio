export default {
    namespaced: true,
    state: {
        cart: null
    },
    getters: {
        getCart(state) {
            return state.cart;
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
