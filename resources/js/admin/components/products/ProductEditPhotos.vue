<template>
    <div>
        <div>
            <div class="grid-margin">
                <button class="btn btn-primary">Добавить фото</button>
                <button class="btn" @click="toggleUrlUploadForm">Загрузить по url</button>
            </div>
            <div v-if="urlUploadForm">
                <div class="form-group">
                    <label for="img-url">Ссылка</label>
                    <div class="d-flex flex-row">
                        <input type="text" class="form-control product_edit_url_form" name="img-url">
                        <button class="btn btn-primary">Загрузить</button>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <img src="https://google.com" alt="">
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <div>product1-300.jpg</div>
                        <div>product1-300.jpg</div>
                        <div>product1-300.jpg</div>
                    </div>
                    <div>
                        <button class="btn btn-danger">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h6>Видео</h6>
                </div>
                <div>
                    video goes here...
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                urlUploadForm: false
            }
        },
        methods: {
            toggleUrlUploadForm() {
                this.urlUploadForm = !this.urlUploadForm;
            }
        }
    }
</script>
<style>
    .product_edit_url_form {
        margin-right: 10px;
    }
</style>
