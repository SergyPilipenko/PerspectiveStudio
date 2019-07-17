<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <label for="url">URL:
                    <input type="text" class="form-control" id="url" v-model="url">
                </label>
                <input type="submit" class="btn btn-success" value="Загрузить" @click="download">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['type', 'routes'],
        created() {
            this.action = "/"+JSON.parse(this.routes)['admin.import.parse'];
        },
        data() {
            return {
                url: ''
            }
        },
        methods: {
            download() {
                let self = this;
                let formData = new FormData();
                formData.append('type', this.type);
                formData.append('url', this.url);

                axios.post(this.action, formData).then(function (data) {
                    self.$emit('fileUploaded', data.data);
                    self.$emit('link', self.url);
                });
            }
        }
    }
</script>