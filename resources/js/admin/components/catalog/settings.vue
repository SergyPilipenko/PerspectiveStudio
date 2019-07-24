<template>
    <div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="import_setting_name">Название конфигурации</label>
                            <input type="text" class="form-control" name="import_setting_name" id="import_setting_name" v-model="importSettingName">
                        </div>
                    </div>
                </div>
                <button @click="impSetting">clickMe</button>
                <div>
                    <b-tabs content-class="mt-3">
                        <b-tab title="Файл" active>
                            <form :action="filePriceImportAction"  method="POST" enctype='multipart/form-data'>
                                <input type="hidden" name="_token" :value="token">
                                <input type="hidden" name="type" :value="type">

                                <label for="price_file_upload">Выберите файл</label>
                                <input type="file" id="price_file_upload">
                                <input type="submit" class="btn btn-success">
                            </form>
                        </b-tab>
                        <b-tab title="Ссылка на файл">
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['import_setting', 'file_import_price_action'],
        data() {
            return {
                importSettingName : this.import_setting.title,
                url: this.import_setting.importable.link,
                selected: this.import_setting.importable.update_periods,
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
                filePriceImportAction: this.file_import_price_action,
                type: this.import_setting.importable_type,
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
            }
        },
        methods: {
            impSetting() {
                console.log(this.import_setting.importable.link)
            }
        }
    }
</script>