<template>
    <transition name="fade">
        <div
                :class="'alert alert-flash alert-'+level"
                role="alert"
                v-show="show"
        >
            <div  class="flash-message-body" >
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
        props: ['message', 'errors_list'],
        data() {
            return {
                body: this.message,
                level: 'success',
                show: false,
                hideTimer: false,
                mouseIn: false,
                errors: []
            }
        },
        created() {
            if(this.message) {
                this.flash({
                    message: this.message
                });
            }
            if(Object.keys(this.errors_list).length) {
                this.flash({
                    message: 'Error:',
                    errors: this.errors_list,
                    level: 'error'
                })
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
            flashErrors(errors) {
                if(this.hideTimer) return;
                this.body = data.message;
                this.level = data.level;
                this.errors = data.errors;
                this.show = true;
                this.hide();
            },
            mouseOver: function(){
                this.mouseIn = !this.mouseIn;
            },
            hide() {
                if(!this.hideTimer && !this.mouseIn) {
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
    .alert-flash {
        position: fixed;
        right: 40px;
        top: 95px;
        z-index: 1000000;
        background-color: #569211;
        color: #fff;
        font-family: inherit;
        font-size: 0.875rem;
        line-height: 1;
        font-weight: 400;
    }
    .flash-message-body {
        padding-right: 15px;
    }
    .alert.alert-flash.alert-error {
        background-color: #ff1414;
    }

    .alert-flash span {
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
