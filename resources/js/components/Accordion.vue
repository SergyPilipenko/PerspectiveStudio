<template>
    <div role="tablist">
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab" @click="toggle">
                <b-button block href="#" v-b-toggle.accordion-1 variant="info" :class="arrowClass">{{header}}</b-button>
            </b-card-header>
            <b-collapse id="accordion-1" :visible="visible" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-card-text><slot></slot></b-card-text>
                </b-card-body>
            </b-collapse>
        </b-card>
    </div>
</template>
<script>
    export default {
        props: ['header'],
        data() {
            return {
                visible: false,
                // class: "ti-angle-down"
            }
        },
        methods: {
            toggle() {
                this.visible = !this.visible;
            }
        },
        computed: {
            arrowClass() {
                return !this.visible ? "ti-angle-down" : "ti-angle-up";
            }
        }
    }
</script>
