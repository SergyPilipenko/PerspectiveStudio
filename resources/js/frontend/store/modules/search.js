export default {
    namespaced: true,
    state: {
        show: false
    },
    getters: {
        getShow(state) {
            return state.show;
        },
    },
    mutations: {
        showModalSearch(state) {
            state.show = true
        },
        hideModalSearch(state) {
            state.show = false
        }
    },
    actions: {

    }
}
