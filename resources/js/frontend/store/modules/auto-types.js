export default {
    namespaced: true,
    state: {
        brands: [],
        auto_types: []
    },
    getters: {
        getAutoTypes(state) {
            return state.auto_types;
        },
        getAutoBrands(state) {
            return state.brands;
        }
    },
    mutations: {
        addAutoTypes(state, newValue) {
            state.auto_types = newValue;
        },
        addAutoBrands(state, newValue) {
            state.brands = newValue;
        },
    },
    actions: {
        setAutoTypes(context, payload) {
            context.commit('addAutoTypes', payload);
        },
        setAutoBrands(context, payload) {
            context.commit('addAutoBrands', payload);
        },
    }
}
