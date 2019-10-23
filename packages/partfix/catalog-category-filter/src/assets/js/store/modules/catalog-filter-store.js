import router from "../../../../../../../../resources/js/app";

export default {
    namespaced: true,
    state: {
        maxOptionsShowCount: 9,
        blocks: [],
        requiredBlockProperties: [
            'id',
            'title',
            'code',
            'type',
            'options',
            'show',
            'showAllOptions'
        ],
        requestParams: []
    },
    getters: {
        getBlocks(state) {
            return state.blocks;
        },
        getBlockById: state => id => {
            if(state.blocks.length) {
                return state.blocks.find(block => block.id === id);
            }
        },
        isSelected: state => payload => {
            if(state.requestParams[payload.blockCode] != undefined && state.requestParams[payload.blockCode].indexOf(payload.value.toLowerCase()) != -1) {
                return true;
            } return false;
        },
        getRequestParams(state) {
            return state.requestParams;
        },
        getRequiredBlockProperties(state) {
            return state.requiredBlockProperties;
        },
        getMaxOptionsShowCount(state) {
            return state.maxOptionsShowCount;
        }
    },
    mutations: {
        setRequestParameters (state, payload) {
            var params = router.currentRoute.query,
                requestParams = [];
            for(let i in params) {
                requestParams[i] = params[i].split(',');
            }
            state.requestParams = requestParams;
        },
        setBlock(state, payload) {
            state.blocks.push(payload);
        },
        toggleBlock(state, payload) {
            var blocks = state.blocks;
            for(let i = 0; i <= blocks.length; i++) {
                if(blocks[i].id == payload) {
                    blocks[i].show = !blocks[i].show;
                    break;
                }
            }
        },
        addRequestParam(state, payload){
            if(state.requestParams[payload.blockCode] == undefined) {
                state.requestParams[payload.blockCode] = [];
            }
            if(state.requestParams[payload.blockCode].indexOf(payload.value.toLowerCase()) == -1) {
                state.requestParams[payload.blockCode].push(payload.value);
            };
        },
        removeRequestParam(state, payload){
            if(state.requestParams[payload.blockCode]) {
                state.requestParams[payload.blockCode] = state.requestParams[payload.blockCode].filter(param => param != payload.value);
                if(!state.requestParams[payload.blockCode].length) {
                    delete state.requestParams[payload.blockCode];
                }
            }
        },
        showAllOptions(state, payload) {
            var blocks = state.blocks;
            for(let i = 0; i <= blocks.length; i++) {
                if(blocks[i].id == payload) {
                    blocks[i].showAllOptions = !blocks[i].showAllOptions;
                    break;
                }
            }
        },
    },
    actions: {
        addBlock({ commit, state }, block) {
            var error = false;
            state.requiredBlockProperties.map(property => {
                if(block[property] === undefined) {
                    if(error) return;
                    console.error('Свойство "' + property + '" не найдено');
                    error = true;
                }
            });
            if(error) return;
            commit('setBlock', block);
        },
        getFilteredProductsCount({ commit, state }) {

            let form = new FormData();
            var data = [];
            for (let i in state.requestParams) {
                for(let x in state.blocks) {
                    if(state.blocks[x].code == i) {
                        data.push({
                            id: state.blocks[x].id,
                            code: state.blocks[x].code,
                            type: state.blocks[x].type,
                            value: state.requestParams[i]
                        });
                    }
                }
            }
            form.append('data', JSON.stringify(data));

            axios.post('/set-car-year', form)
                .then(data => {
                });
        },
        toggleOption({ commit, state, dispatch }, payload) {
            var blocks = state.blocks;
            for(let i = 0; i <= blocks.length; i++) {
                if(blocks[i].id == payload.blockId) {
                    blocks[i].options[payload.optionIndex].selected = !blocks[i].options[payload.optionIndex].selected;
                    blocks[i].options[payload.optionIndex].selected
                        ? commit('addRequestParam', {blockCode: blocks[i].code, value: blocks[i].options[payload.optionIndex].value.toLowerCase()})
                        : commit('removeRequestParam', {blockCode: blocks[i].code, value: blocks[i].options[payload.optionIndex].value.toLowerCase()});
                    break;
                }
            }

            dispatch('getFilteredProductsCount');

        }
    }
}
