export default {
    namespaced: true,
    state: {
        years: [1990,2019],
        brands: [],
        models: [],
        modifications: [],
        filteredModifications: [],
        distinctModels: [],
        bodyTypes: [],
        engines: [],
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
        getBodyTypes: function (state) {
            return state.bodyTypes
        },
        getDistinctModels: function (state) {
            return state.distinctModels
        },
        getFilteredModifications: function (state) {
            return state.filteredModifications
        },
        getEngines: function (state) {
            return state.engines
        },
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
        addDistinctModels: function (state, newValue) {
            state.distinctModels = newValue;
        },
        addBodyTypes: function (state, newValue) {
            state.bodyTypes = newValue;
        },
        addEngines: function (state, newValue) {
            state.engines = newValue;
        },
        clearModifications: function (state) {
            state.modifications = [];
        },
    },
    actions: {
        resetModifications: function(context){
            context.commit('resetModifications')
        },
    }
}
