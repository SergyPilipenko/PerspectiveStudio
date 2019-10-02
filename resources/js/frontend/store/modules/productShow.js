export default {
    namespaced: true,
    state: {
        product: null
    },
    getters: {
        getProduct(state) {
            return state.product;
        },
    },
    mutations: {
        setProduct(state, newValue) {
            state.product = newValue;
        },
    },
    actions: {

    }
}
