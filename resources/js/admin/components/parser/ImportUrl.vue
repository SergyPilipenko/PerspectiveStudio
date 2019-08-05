<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="timeUpdateSelect">Обновлять каждые</label>
                    <select v-model="selected" class="form-control" id="timeUpdateSelect">
                        <option v-for="option in timeUpdateOptions" :value="option.hours" v-text="option.label"></option>
                    </select>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="import_url_container">
                            <label for="url">URL:
                                <input type="text" class="form-control" id="url" v-model="url">
                            </label>
                            <input type="submit" class="btn btn-success" value="Загрузить" @click="download(type)">
                        </div>
                    </div>
                </div>
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
                selected: 6,
                timeUpdateOptions:
                    [
                        {
                            id: 1,
                            hours: 6,
                            label: '6 часов'
                        },
                        {
                            id: 2,
                            hours: 12,
                            label: '12 часов'
                        },
                        {
                            id: 3,
                            hours: 24,
                            label: '24 часов'
                        }
                    ],
                url: '',
            }
        },
        methods: {
            download(type) {
                let self = this;
                let formData = new FormData();
                formData.append('type', type);
                formData.append('url', this.url);

                axios.post(this.action, formData).then(function (data) {
                    self.$emit('fileUploaded', data.data);
                    self.$emit('link', self.url);
                    self.$emit('updatePeriod', self.selected);
                });
            }
        }
    }
</script>

<style>
    .import_url_container {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    .import_url_container label{
        width: 70%;
    }
    .import_url_container input[type=submit] {
        margin-top: 9px;
    }
</style>