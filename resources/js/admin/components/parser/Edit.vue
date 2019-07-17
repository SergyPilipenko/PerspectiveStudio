<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <label for="uploadType">Источник:</label>
                <select name="uploadType" id="uploadType" class="form-control">
                    <option value="App\Models\Admin\Import\ImportByUrl">HTTP</option>
                    <option value="App\Models\Admin\Import\ImportByFile">Загрузка с компьютера</option></select>
            </div>
        </div>
        <div class="row m-t-20"><div class="col-md-4">
            <label for="importFileTitle">
                <span class="required">Название</span>
                <input type="text" id="importFileTitle" class="form-control form-control ">
            </label>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table importFileTable">
                    <table>
                        <thead>
                        <tr>
                            <th>
                                <select name="columnType[]" class="form-control">
                                    <option value=""> - выбрать поле - </option>
                                    <option value="name">Название</option>
                                    <option value="brand">Производитель</option>
                                    <option value="article">Код</option>
                                    <option value="description">Описание</option>
                                    <option value="used">Б/У</option>
                                    <option value="price">Цена</option>
                                    <option value="quantity">Кол-во</option>
                                    <option value="original">Ориг. производители</option>
                                    <option value="picture">Фото</option>
                                </select>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['setting'],
        data() {
            return {

            }
        },
        created() {
            console.log(JSON.parse(`${this.setting}`));
        },
        computed: {
            importSetting() {

                return JSON.parse(this.setting);
            }
        }
    }
</script>