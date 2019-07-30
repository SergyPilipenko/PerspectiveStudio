export default {
    namespaced: true,
    state: {
        years: [1990,1991,1992,1993,1994,1995,2016],
        brands: [],
        models: [],
        modifications: []
    },
    getters: {
        getYears: function (state) {
            return state.years
        },
        getBrands: function (state) {
            return state.brands
        },
        getModels: function (state) {
            return state.models
        },
        getModifications: function (state) {
            return state.modifications
        }
    },
    mutations: {
        addBrands: function(state, newValue){
            state.brands = newValue;
        },
        addModels: function(state, newValue){
            state.models = newValue;
        },
        addModifications: function (state, newValue) {
            state.modifications = newValue;
        },
        clearModifications: function (state) {
            state.modifications = [];
        }
    },
    actions: {
        // changeAmount: function(context, payload){
        //     context.commit('changeAmount', payload)
        // },
    }
}
