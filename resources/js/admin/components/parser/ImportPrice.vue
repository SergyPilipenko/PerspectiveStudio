<template>
    <div>
        <form :action="action" method="POST" enctype='multipart/form-data' >
            <input type="hidden" name="_token" :value="token">
            <input type="hidden" name="type" :value="importableType">
            <div class="control-container">
                <div v-if="importableType == 'App\\Models\\Admin\\Import\\ImportByFile'">
                    <input type="file"
                           ref="file"
                           name="file"

                           @change="handleFileUpload" >
                </div>
                <a v-else :href="importSetting.importable.link">test</a>
                <button class="btn btn-xs btn-default"><i class="fa fa-upload" @click="submitForm" aria-hidden="true" ></i>Загрузить прайс лист</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['type', 'routes', 'action'],
        data() {
            return {
                file: '',
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
                // actionstest: this.routesList
            }
        },
        computed: {
            importSetting() {
                return JSON.parse(this.splice(this.type))
            },
            importableType() {
                return this.importSetting.importable_type;
            },
            formAction() {
                return JSON.parse(this.routes)['admin.import.price'];
            }
        },
        methods: {
            splice(str) {
                return `${str}`.slice(1,-1);
            },
            submitForm() {
                let self = this;
                let formData = new FormData();
                formData.append('file', this.file);

                // axios.post(this.action, formData).then(function (data) {
                //     self.$emit('fileUploaded', data.data);
                // });
            },
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            }
        }
    }
</script>