<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="import_setting_name">Название конфигурации</label>
                    <input type="text" class="form-control" name="import_setting_name" id="import_setting_name" v-model="importSettingName">
                </div>
            </div>
        </div>
        <div>
            <b-tabs content-class="mt-3">
                <b-tab title="Файл" active @click="changeType('App\\Models\\Admin\\Import\\ImportByFile')">
                    <upload-form
                                 @fileUploaded="renderPreview"
                                 :routes="routes"
                                 :type="'App\\Models\\Admin\\Import\\ImportByFile'"
                    ></upload-form>
                </b-tab>
                <b-tab title="Ссылка на файл"  @click="changeType('App\\Models\\Admin\\Import\\ImportByUrl')">
                    <import-url
                            :type="'App\\Models\\Admin\\Import\\ImportByUrl'"
                            :routes="routes"
                            @fileUploaded="renderPreview"
                            @link="uploadLink"
                            @updatePeriod="updatePeriod"
                    ></import-url>
                </b-tab>
            </b-tabs>
        </div>
<!--        <div class="row">-->
<!--            <div class="col-md-4">-->
<!--                <label for="uploadType">Источник:</label>-->
<!--                    <select name="uploadType"-->
<!--                            class="form-control"-->
<!--                            id="uploadType"-->
<!--                            v-model="selected"-->
<!--                            @change="changeSelect">-->
<!--                        <option v-for="option in options"-->
<!--                                :value="option.value"-->
<!--                                v-text="option.name">-->
<!--                        </option>-->
<!--                    </select>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div v-if="selected === 'App\\Models\\Admin\\Import\\ImportByUrl'">-->
<!--            -->
<!--        </div>-->
<!--        <div v-if="selected == 'App\\Models\\Admin\\Import\\ImportByFile'">-->
<!--            -->
<!--        </div>-->
        <preview-table v-show="preview"
                       :previewData="previewData"
                       :routes="routes"
                       :tester="routes"
                       :type="selected"
                       :link="link"
                       :periodUpdate="period"
                       :columns="tableColumns"
                       :title="importSettingName"
        ></preview-table>
    </div>
</template>

<script>
    import UploadForm from './UploadForm.vue';
    import PreviewTable from './PreviewTable.vue';
    import ImportUrl from './ImportUrl.vue';

    export default {
        props: ['routes','columns'],

        components: { UploadForm, PreviewTable, ImportUrl },

        data() {
            return {
                upload: true,
                preview: false,
                previewData: [],
                importSettingName: '',
                link: '',
                period: '',
                file: '',
                selected: 'App\\Models\\Admin\\Import\\ImportByFile',
                // options: [
                //     {
                //
                //         value: 'App\\Models\\Admin\\Import\\ImportByUrl',
                //         name: 'HTTP'
                //     },
                //     {
                //         value: 'App\\Models\\Admin\\Import\\ImportByFile',
                //         name: 'Загрузка с компьютера'
                //     }
                // ],
            }
        },

        computed: {

            tableColumns() {
                return JSON.parse(this.columns)
            }

        },

        methods: {
            renderPreview(data) {
                this.preview = true;
                this.previewData = data;
            },
            changeSelect() {
                this.previewData = [];
                this.preview = false;
            },
            uploadLink(link,period) {
                this.link = link;
                this.updatePeriod = period;
            },
            updatePeriod(period) {
                this.period = period;
            },
            changeType(type) {
                this.preview = false;
                this.selected = type;
            }

        },
    }
</script>