export default {
    namespaced: true,
    state: {
        popupBlackLayout: false
    },
    getters: {
        getPopupLayout(state) {
            return state.popupBlackLayout;
        }
    },
    mutations: {
        togglePopupBlackLayout(state) {
            state.popupBlackLayout = !state.popupBlackLayout
        },
        hidePopupLayout(state) {
            state.popupBlackLayout = false
        },
    },
    actions: {

    }
}
