<template>
    <div>
        <form :action="action" method="post" ref="form">
            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="_token" :value="token">

            <button
                :class="className"
                v-text="elementText"
                data-toggle="modal" data-target="#confirmModal"
                @click.prevent=""
            >text</button>
        </form>
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">{{ modalHeader }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="body">
                        {{ body }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
                        <button type="button" class="btn btn-primary" @click="confirm">Да</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['action', 'body', 'classes', 'text', 'header'],

        data() {
            return {
                token: axios.defaults.headers.common['X-CSRF-TOKEN']
            }
        },
        computed: {
            className() {
                return this.classes ? this.classes : 'btn btn-danger'
            },
            elementText() {
                return this.text ? this.text : 'Удалить'
            },
            modalHeader() {
                return this.header ? this.header : 'Вы действительно хотите удалить этот элемент'
            }
        },
        methods: {
            confirm() {
                this.$refs.form.submit()
            }
        }
    }
</script>
