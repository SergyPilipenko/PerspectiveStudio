export default {
    namespaced: true,
    state: {
        years: [1990,1991,1992,1993,1994,1995,2010,2011,2012,2013,2014,2015,2016],
        brands: [],
        models: [],
        modifications: [],
        filteredModifications: []
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
        },
        getFilteredModifications: function (state) {
            return state.filteredModifications
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
        addFilteredModifications: function (state, newValue) {
            state.filteredModifications = newValue;
        },
        clearModifications: function (state) {
            state.modifications = [];
            state.filteredModifications = [];

        },
    },
    actions: {
        // resetModifications: function(context, payload){
        //     context.commit('changeAmount', payload)
        // },
    }
}
