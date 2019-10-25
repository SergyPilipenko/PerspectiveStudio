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
        preloadLayout: false,
        requestParams: null,
        filterQtyAction: '/api/catalog/category/filterqty',
        categoryId: null,
        currentSubmitLink: '',
        categoryLink: ''
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
        },
        getFilterQtyAction(state){
            return state.filterQtyAction
        },
        getPreloadLayout(state) {
            return state.preloadLayout
        },
        getCurrentSubmitLink(state) {
            return state.currentSubmitLink
        },
        getCategoryLink(state) {
            return state.categoryLink
        }
    },
    mutations: {
        setRequestParameters (state, payload) {
            if(state.requestParams) return;
            var params = router.currentRoute.query,
                requestParams = [];
            for(let i in params) {
                requestParams[i] = params[i].split(',');
            }
            state.requestParams = requestParams;
        },
        setCurrentSubmitLink (state, payload) {
            state.currentSubmitLink = payload
        },
        setCategoryLink (state, payload) {
            state.categoryLink = payload
        },
        setBlock(state, payload) {
            state.blocks.push(payload);
        },
        showPreloadLayout(state) {
            state.preloadLayout = true
        },
        hidePreloadLayout(state) {
            state.preloadLayout = false
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
        addOrUpdateFirstParam(state, payload) {
            if(state.requestParams[payload.blockCode] == undefined) {
                state.requestParams[payload.blockCode] = [];
            }
            if(state.requestParams[payload.blockCode].indexOf(payload.value.toLowerCase()) == -1) {
                if(!state.requestParams[payload.blockCode].length) {
                    state.requestParams[payload.blockCode].push(payload.value);
                } else {
                    state.requestParams[payload.blockCode][0] = payload.value;
                }
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
        setFilterQtyAction(state, payload) {
            state.filterQtyAction = payload
        },
        setCategoryId(state, payload) {
            state.categoryId = payload
        },
        resetCurrentSubmitLink(state) {
            state.currentSubmitLink = ''
        }
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
        getFilteredProductsCount({ commit, state, getters, dispatch }, payload) {

            let form = new FormData();
            var data = [];
            for (let i in state.requestParams) {
                form.append(i, state.requestParams[i].join(','))
                // for(let x in state.blocks) {
                //     if(state.blocks[x].code == i) {
                //         data.push({
                //             id: state.blocks[x].id,
                //             code: state.blocks[x].code,
                //             type: state.blocks[x].type,
                //             value: state.requestParams[i]
                //         });
                //     }
                // }
            }
            // form.append('data', JSON.stringify(data));
            form.append('categoryId', state.categoryId);
            axios.post(state.filterQtyAction, form)
                .then(data => {
                    dispatch('showOptionSubmitLink', {optionData: payload, result: data.data});
                });
        },
        hideSubmitLinks({state}) {
            var blocks = state.blocks;
            blocks.map(block => {
                if(block.options && block.options.length) {
                    block.options.map(option => {
                        if(option.showSubmitLink && option.showSubmitLink == true) {
                            option.showSubmitLink = false;
                        }
                    })
                }
            });
        },
        showOptionSubmitLink({ commit, state, dispatch, getters }, payload) {
            var block = getters.getBlockById(payload.optionData.blockId);
            if(block) {
                dispatch('generateSubmitLink');
                block.options[payload.optionData.optionIndex].link = getters.getCurrentSubmitLink;
                block.options[payload.optionData.optionIndex].submitQty = payload.result;
                block.options[payload.optionData.optionIndex].showSubmitLink = true;
            }
            commit('hidePreloadLayout');
        },
        toggleOption({ commit, state, dispatch }, payload) {
            commit('showPreloadLayout');
            dispatch('hideSubmitLinks');
            commit('resetCurrentSubmitLink');
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
            dispatch('getFilteredProductsCount', payload);
        },

        generateSubmitLink({state, commit, getters}){
            var params = state.requestParams,
                link = getters.getCategoryLink,
                x = 0;
            for(let i in params) {
                if(!x) {
                    link += '?'
                } else {
                    link+= '&'
                }
                link += i + '=' + params[i].join(',');
                x++;
            }
            commit('setCurrentSubmitLink', link);
        },
        priceSubmit({state, dispatch, commit}, payload) {
            commit('showPreloadLayout');
            commit('addOrUpdateFirstParam', {
                blockCode: payload.code + '_from',
                value: payload.inputMin.toString()
            });
            commit('addOrUpdateFirstParam', {
                blockCode: payload.code + '_to',
                value: payload.inputMax.toString()
            });
            dispatch('generateSubmitLink');
            window.location.href = state.currentSubmitLink
        }
    }
}
