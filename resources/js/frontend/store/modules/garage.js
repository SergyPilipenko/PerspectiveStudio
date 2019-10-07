export default {
    namespaced: true,
    state: {
        cars: [],
        currentAuto: null
    },
    getters: {
        getCars(state) {
            return state.cars;
        },
        getCurrentAuto(state) {
            return state.currentAuto;
        }
    },
    mutations: {
        addCars(state, newValue) {
            state.cars = newValue;
        },
        addCurrentAuto(state, newValue) {
            state.currentAuto = newValue;
        },
    },
    actions: {
        setCars(context, payload) {
            context.commit('addCars', payload);
        },
        setCurrentAuto(context, payload) {
            context.commit('addCurrentAuto', payload);
        },
    }
}
