<template>
    <div>
        <div class="form-group">
            <div class="form-check form-check-flat form-check-primary d-flex align-content-center flex-column">
                <div class="d-flex flex-row">
                    <label class="form-check-label tec-doc-node">
                        <input type="checkbox"
                               class="form-check-input"
                               name="node[]"
                               :value="node.id"
                               v-model="checked"
                               @change="checkOrUncheckParentCheckbox">
                            {{ node.description }}
                        <i class="input-helper"></i>
                    </label>
                    <button type="button"
                            @click="show()"
                            v-if="node.children.length"
                    >
                        <i class="ti-arrow-circle-down" v-if="!visibility"></i>
                        <i class="ti-arrow-circle-up" v-else></i>
                    </button>
                </div>
            </div>
        </div>
        <ul v-if="node.children" v-show="visibility">
            <tecdoc-categories-node-tree
                :node="category"
                v-for="category in node.children"
                :key="category.id"
                :checked="checked"
            ></tecdoc-categories-node-tree>
        </ul>
    </div>
</template>

<script>
    import { EventBus } from "./event-bus";
    EventBus.$on('handleFunction', () => {
        console.log(`Oh, that's nice. It's gotten `)
    });
    export default {
        name: "tecdoc-categories-node-tree",
        props: {
            node: Object,
            checked: Boolean
        },
        data() {
            return {
                visibility: false,
            }
        },
        methods: {
            show() {
                this.visibility = !this.visibility
            },
            test() {
                console.log(1);
            },
            checkOrUncheckParentCheckbox() {
                EventBus.$emit('handleFunction');
            }
        }
    }
</script>

<style>
    .form-check-label.tec-doc-node {
        margin-bottom: 0;
    }
</style>
