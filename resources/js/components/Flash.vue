<template>
    <transition name="fade">
        <div
                :class="'alert allert-flash alert-'+level"
                role="alert"
                v-show="show"
        >
            <div  class="flash-message-body">
                <div v-text="body"></div>
                <div v-if="errors">
                    <ul v-for="(error, errorName) in errors">
                        <li>
                            <b>{{errorName}}:</b>
                            <ul>
                                <li v-for="e in error" v-text="e"></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <span @click="show = false"><i class="fa fa-times" aria-hidden="true"></i></span>
        </div>
    </transition>

</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: this.message,
                level: 'success',
                show: false,
                hideTimer: false,
                errors: []
            }
        },
        created() {
            if(this.message) {
                this.flash({
                    message: this.message
                });
            }

            window.events.$on(
                'flash', data => {this.flash(data)}
            );
        },
        methods: {
            flash(data){
                console.log(data);
                if(this.hideTimer) return;
                this.body = data.message;
                this.level = data.level;
                this.errors = data.errors;
                this.show = true;
                this.hide();
            },
            hide() {
                if(!this.hideTimer) {
                    this.hideTimer = true;
                    setTimeout(() => {
                        this.show = false;
                        this.hideTimer = false;
                    }, 5000);
                }

            },

        }
    }
</script>

<style>
    .allert-flash {
        position: fixed;
        right: 25px;
        top: 95px;
        z-index: 1000;
    }
    .flash-message-body {
        padding-right: 15px;
    }
    .allert-flash span {
        position: absolute;
        top: 2px;
        right: 0px;
        color: #fff;
        padding-right: 7px;
        padding-left: 7px;
        cursor: pointer;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
        opacity: 0;
    }


</style>
