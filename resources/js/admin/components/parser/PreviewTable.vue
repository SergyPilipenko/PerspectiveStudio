<template>
    <div>
        <form action="/admin/parser/store" method="POST" id="previewForm">
            <div class="row m-t-20">
                <div class="col-md-4">
                    <label for="importFileTitle" >
                        <span class="required">Название</span>
                        <input
                                :class="'form-control '+errorClass"
                                @keyup="afterError"
                                type="text" class="form-control" id="importFileTitle" v-model="title">
                        <div v-if="errors.title" class="error">
                            <p
                                    :class="errorClass"
                                    v-for="error in errors.title"
                                    v-text="error">

                            </p>
                        </div>
                    </label>
                </div>
            </div>
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
            <input type="submit" class="btn btn-success" value="Сохранить" @click.prevent="upload">
        </form>
    </div>
</template>

<script>
    export default {
        props: ['previewData', 'routes', 'type','link','columns'],

        data() {
           return {
               key: "",
               selected: [],
               selectAll: false,
               headers: [],
               title: '',
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
                    this.errorClass = '';
                    this.errors.title = [];
                    return true
                }
                this.errors = {
                    title: []
                };
                if(!this.title) {
                    this.errors.title.push("Это поле обязательно для заполнения");
                    this.errorClass = 'error'
                }
                if(this.title.length < 3) {
                    this.errors.title.push("Это поле должно содержать минимум 3 символа");
                    this.errorClass = 'error'
                }
            },


            upload() {

                if(!this.checkTitle()) {
                    flash('Не удалось сохранить схему загрузки', 'error');
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
                formData.append('columns', JSON.stringify(selects));

                axios.post("/"+this.routeList['admin.import.store'], formData)

                    .then(data => {
                        if(data.data) {
                            window.location.href = "/"+this.routeList['admin.import.index'];
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