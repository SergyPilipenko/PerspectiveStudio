<template>
    <div>
        <div class="preview-form-container">
            <form action="/admin/parser/store" method="POST" id="previewForm">
                <table class="table m-t-20 importFileTable">
                    <thead>
                    <tr>
                        <th scope="col" v-for="(item, index) in selects" :key="index" v-model="key">
                            <select class="form-control" name="columnType[]" @change="onChange($event,index)" v-model="selects[index].value">
                                <option value="" > - выбрать поле - </option>
                                <option :value="column.id" v-for="column in columns" v-text="column.title"></option>
                            </select>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="row in rows">
                        <td v-for="cell in row" v-text="cell">
                            <input type="text">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <input type="submit" class="btn btn-success" value="Сохранить" @click.prevent="upload">
    </div>
</template>

<script>
    export default {
        props: ['previewData', 'routes', 'type', 'link','columns', 'title', 'periodUpdate'],

        data() {
           return {
               key: "",
               selected: [],
               selectAll: false,
               headers: [],
               // title: '',
               errors: [],
               errorClass: '',
           }
        },
        computed: {
            rows: function() {
                return this.previewData.rows;
            },
            maxRowLength: function() {
                return this.previewData.max_length;
            },
            routeList() {
                return JSON.parse(this.routes);
            },

            selects() {
                let selects = [];
                let alphabet = ' abcdefghijklmnopqrstuvwxyz'.toUpperCase().split('');
                for(let i = 1; i <= this.maxRowLength; i++) {
                    selects.push({
                        column: alphabet[i],
                        value: ''
                    })
                }
                return selects;
            }
        },
        mounted() {

        },
        methods: {
            afterError() {
                if(this.errors.title) {
                    this.checkTitle();
                }
            },
            checkTitle() {
                if(this.title && this.title.length >= 3) {
                    // this.errorClass = '';
                    // this.errors.title = [];
                    return true
                } else return false;
                // this.errors = {
                //     title: []
                // };
                // if(!this.title) {
                //     this.errors.title.push("Это поле обязательно для заполнения");
                //     this.errorClass = 'error'
                // }
                // if(this.title.length < 3) {
                //     this.errors.title.push("Это поле должно содержать минимум 3 символа");
                //     this.errorClass = 'error'
                // }
            },


            upload() {

                if(!this.checkTitle()) {
                    flash('Введите название конфигурации', 'error');
                    return;
                }


                const selects = this.selects;
                var selected = selects.filter(header => header.value !== "");
                var unique = [...new Set(selected.map(selected => selected.value))];
                console.log(selected.length);
                console.log(unique.length);


                if(selected.length != unique.length) {
                    flash('Поля не должны совпадать', 'error');
                    return;
                }

                let formData = new FormData();
                formData.append('title', this.title);
                formData.append('type', this.type);
                formData.append('link', this.link);
                formData.append('updatePeriod', this.periodUpdate);
                formData.append('columns', JSON.stringify(selects));

                axios.post("/"+this.routeList['admin.import.store'], formData)

                    .then(data => {
                        if(data.data) {
                            window.location.href = "/admin/catalog";
                        }
                    })
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
            },
            onChange(event, index) {
                if(this.headers[index] == undefined) {
                    this.headers.push({
                        id: index,
                        value: event.target.value
                    })
                } else if (event.target.value == "") {
                    this.headers.splice(index, 1)
                } else  {
                    this.headers[index].value = event.target.value
                }
            },
        }

    }
</script>

<style>
    .importFileTable thead tr th:first-child{
        padding-left: 0;
    }
    .importFileTable thead tr th:last-child{
        padding-left: 0;
    }
    label[for=importFileTitle] {
        width: 100%;
    }
</style>