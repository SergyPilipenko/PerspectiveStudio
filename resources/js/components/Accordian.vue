<template>
    <div class="accordian">
        <div class="accordian-header" @click="toggleVisibility">
            <slot name="header"></slot>
            <div class="control-button">
                <div v-if="!hasIconSlot">
                    <i class="ti-arrow-circle-down" v-if="!bodyVisibility"></i>
                    <i class="ti-arrow-circle-up" v-if="bodyVisibility"></i>
                </div>
                <div v-else>
                    <slot name="icon"></slot>
                </div>
            </div>
        </div>
        <div class="accordian-body" v-show="bodyVisibility">
            <slot name="body"></slot>
        </div>
    </div>
</template>
<script>
    import PartfixCkeditor from "./PartfixCkeditor";

    export default {
        components: {
            'PartfixCkeditor': PartfixCkeditor
        },

        props: {
            default: {
                default: true,
                type: Boolean
            }
        },

        data() {
            return {
                bodyVisibility: this.default,
            }
        },
        computed: {
            hasIconSlot() {
                return !!this.$slots['icon'];
            }
        },
        methods: {
            toggleVisibility() {
                this.bodyVisibility = !this.bodyVisibility
            }
        }
    }
</script>

<style>

</style>
