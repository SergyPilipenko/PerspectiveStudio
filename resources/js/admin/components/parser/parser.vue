<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <label for="uploadType">Источник:</label>
                    <select name="uploadType"
                            class="form-control"
                            id="uploadType"
                            v-model="selected"
                            @change="changeSelect">
                        <option v-for="option in options"
                                :value="option.value"
                                v-text="option.name">
                        </option>
                    </select>
            </div>
        </div>
        <div v-if="selected === 'App\\Models\\Admin\\Import\\ImportByUrl'">
            <import-url
                    :type="selected"
                    :routes="routes"
                    @fileUploaded="renderPreview"
                    @link="uploadLink"
            ></import-url>
        </div>
        <div v-if="selected == 'App\\Models\\Admin\\Import\\ImportByFile'">
            <upload-form v-show="upload"
                         @fileUploaded="renderPreview"
                         :routes="routes"
                         :type="selected"
            ></upload-form>
        </div>
        <preview-table v-show="preview"
                       :previewData="previewData"
                       :routes="routes"
                       :type="selected"
                       :link="link"
        ></preview-table>
    </div>
</template>

<script>
    import UploadForm from './UploadForm.vue';
    import PreviewTable from './PreviewTable.vue';
    import ImportUrl from './ImportUrl.vue';

    export default {
        props: ['routes'],

        components: { UploadForm, PreviewTable, ImportUrl },

        data() {
            return {
                upload: true,
                preview: false,
                previewData: [],
                link: '',
                file: '',
                selected: 'App\\Models\\Admin\\Import\\ImportByFile',
                options: [
                    {
                        value: 'App\\Models\\Admin\\Import\\ImportByUrl',
                        name: 'HTTP'
                    },
                    {
                        value: 'App\\Models\\Admin\\Import\\ImportByFile',
                        name: 'Загрузка с компьютера'
                    }
                ],
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
            uploadLink(link) {
                this.link = link;
            }

        },
    }
</script>