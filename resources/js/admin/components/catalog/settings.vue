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
                <div class="grid-margin">
                    <b-tabs content-class="mt-3">
                        <b-tab title="Файл" active v-if="type == 'App\\Models\\Admin\\Import\\ImportByFile'">
                            <div class="row">
                                <form :action="filePriceImportAction"  method="POST" enctype='multipart/form-data'>
                                    <input type="hidden" name="_token" :value="token">
                                    <input type="hidden" name="type" :value="type">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="price_file_upload">Выберите файл</label>
                                            <input type="file" id="price_file_upload" name="file">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="delimiter">Разделитель:</label>
                                            <input class="form-control" type="text" value="," name="delimiter" id="delimiter">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="submit" class="btn btn-success">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </b-tab>
                        <b-tab title="Ссылка на файл" v-if="type == 'App\\Models\\Admin\\Import\\ImportByUrl'">
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
                <div class="row">
                    <div class="col-md-2">
                        <button class="btn btn-primary" @click="saveImportSetting">Сохранить</button>
                    </div>
                    <div class="offset-md-8 col-md-2">
                        <form :action="destroy_action" method="POST">
                            <input type="hidden" name="_token" :value="token">
                            <input type="hidden" name="_method" value="delete">
                            <input type="submit" class="btn btn-danger" value="Удалить">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['import_setting', 'file_import_price_action', 'update_action', 'destroy_action'],
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
            appendUrlData(formData) {
                formData.append('url', this.url);
                formData.append('updatePeriod', this.selected);
            },
            saveImportSetting() {

                let self = this;
                let formData = new FormData();
                formData.append('type', self.type);
                formData.append('title', this.importSettingName);

                if(this.type == "App\\Models\\Admin\\Import\\ImportByUrl") {
                    this.appendUrlData(formData);
                }

                axios.post(this.update_action, formData)
                    .catch(error => {
                        var message = "";
                        if(error.response.data.message) {
                            message = error.response.data.message
                        } else if(error.response.data.exception) {
                            message = error.response.data.exception
                        } else {
                            message = "Не удалось сохранить схему загрузки";
                        }
                        flash(message, 'error', error.response.data.errors)
                    })
                    .then(function (data) {
                        if(data.data) {
                            flash("Новые данные сохранены успешно")
                        }
                });
            }
        }
    }
</script>
