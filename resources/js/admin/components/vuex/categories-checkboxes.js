export default {
    namespaced: true,
    state: {
        selected: [],
    },
    getters: {
        getSelectedCheckboxes: function (state) {
            return state.selected
        },
    },
    mutations: {
        setSelectedCheckboxes: function(state, newValue){
            state.selected = newValue;
        },
    }
}
