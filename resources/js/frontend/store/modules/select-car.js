export default {
    namespaced: true,
    state: {
        years: [1980, new Date().getFullYear()],
        selectedYear: null,
        selectedBrand: null,
        selectedModel: null,
        yearsList: [],
        brands: [],
        models: [],
        modifications: [],
        filteredModifications: [],
        distinctModels: [],
        bodyTypes: [],
        engines: [],
        filteredModelsByYear: [],
        pluck: []
    },
    getters: {
        getYears: function (state) {
            return state.years
        },
        getSelectedYear: function(state) {
            return state.selectedYear
        },
        getSelectedBrand: function(state) {
            return state.selectedBrand
        },
        getSelectedModel: function(state) {
            return state.selectedModel
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
        getYearsList: function (state) {
            return state.yearsList
        },
        getDistinctModels: function (state) {
            return state.distinctModels
        },
        getFilteredModelsByYear: function (state) {
            return state.filteredModelsByYear
        },
        getFilteredModifications: function (state) {
            return state.filteredModifications
        },
        getEngines: function (state) {
            return state.engines
        },
        getPluckedData: function (state) {
            return state.pluck
        },
    },
    mutations: {
        addSelectedYead: function(state, newValue) {
            state.selectedYear = newValue;
        },
        addSelectedBrand: function(state, newValue) {
            state.selectedBrand = newValue;
        },
        addSelectedModel: function(state, newValue) {
            state.selectedModel = newValue;
        },
        clearSelectedBrand: function(state, newValue) {
            state.selectedBrand = null
        },
        clearSelectedModel: function(state, newValue) {
            state.selectedModel = null
        },
        clearModels: function(state) {
            state.models = []
        },
        clearDistinctModels: function(state) {
            state.distinctModels = []
        },
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
        addFilteredModelsByYear: function (state, newValue) {
            state.filteredModelsByYear = newValue;
        },
        clearModifications: function (state) {
            state.modifications = [];
        },
        addYearsList: function (state, newValue) {
            state.yearsList = newValue;
        },
        addPluckData: function (state, newValue) {
            state.pluck = newValue;
        },
        unsetBodyTypes: function (state) {
            state.bodyTypes = [];
        },
        unsetEngines: function (state) {
            state.engines = [];
        },
        unsetModifications: function (state) {
            state.modifications = [];
        },
    },
    actions: {
        setBrands: function(context, payload) {
            let form = new FormData();
            form.append('year', payload.selected_year);
            axios.post(payload.action, form)
                .then(data => {
                context.commit('addBrands', data.data)
            });
        },
        resetModifications: function(context){
            context.commit('resetModifications')
        },
        setCarYear(context, payload) {
            let form = new FormData();
            form.append('selected_year', payload.yearSelected);
            axios.post(payload.action, form);
        },
        setYearsList: function (context, payload) {
            let list = [];
            let first = payload[0];
            while (first <= payload[1]) {
                list.push(first);
                first++;
            }
            context.commit('addYearsList', list.reverse())
        },
        setModels: function (context, payload) {
            context.commit('addModels', payload)
        },
        clearModels: function(context) {
            context.commit('clearDistinctModels');
            context.commit('clearSelectedModel');
            context.commit('clearModels');
        },
        setModifications: function (context, payload) {
            let form = new FormData();
            form.append('model_Ids', payload.model_Ids);
            form.append('EngineType', payload.EngineType);
            form.append('BodyType', payload.BodyType);
            form.append('Capacity', payload.Capacity);
            axios.post(payload.action, form)
                .then(data => {
                    context.commit('addModifications', data.data);
                })
        },
        filterModelsByYear: function (context, payload) {
            const regExp = new RegExp('[0-9]{4}');
            const validModels = payload.models.filter(model => {
                const years = model.constructioninterval.split(' - ');
                const createdAt = years[0].match(regExp);
                const stopped = years[1].match(regExp);

                if(createdAt && stopped) {
                    if(payload.selectedYear >= createdAt[0] && payload.selectedYear <= stopped[0]) {
                        return model
                    }
                } else if(createdAt && !stopped) {
                    if(payload.selectedYear >= createdAt[0]) {
                        return model;
                    }
                } else {
                    console.log(payload.selectedYear);
                    console.log(createdAt);
                    console.log(stopped);
                }
            });

            context.commit('addFilteredModelsByYear', validModels);
        },
        setBodyTypes: function (context, payload) {
            let form = new FormData();
            if(!payload.model_Ids.length) {
                context.commit('unsetBodyTypes');
                context.commit('unsetEngines');
                context.commit('unsetModifications');
                return;

            }
            form.append('model_Ids', payload.model_Ids);
            axios.post(payload.action, form)
                .then(data => {
                    context.commit('addBodyTypes', data.data);
                })
        },
        setEngines: function(context, payload) {
            let form = new FormData();
            form.append('model_Ids', payload.modelIds);
            form.append('body_type', payload.selectedBodyType);
            form.append('selected_year', payload.selectedYear);

            axios.post(payload.action, form)
                .then(data => {
                    context.commit('addEngines', data.data)
                });
        },
        pluck: function (context, payload) {
            let plucked = [];
            for (let el in payload.items) {
                if(payload.items[el][payload.value]) {
                    plucked.push(payload.items[el][payload.value]);
                    continue;
                } continue;
            }
            context.commit('addPluckData', plucked);
        }
    }
}
