<template>
    <table class="table">
        <thead>
            <tr>
                <th>Бренд</th>
                <th v-for="type in autoTypes">{{ type.title }}</th>
            </tr>
            <tr>
                <th></th>
                <th v-for="(type, index) in autoTypes">
                    <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                            <input type="checkbox" name="auto_types[][]"
                                   :value="selectAll"
                                   @input="selectColumnAll(index, type)"
                                   class="form-check-input">
                            Все
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="brand in autoBrands">
                <td>{{ brand.name }}</td>
                <td v-for="type in autoTypes">
                    <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                            <input type="checkbox" name="auto_types[][]"
                                   v-model="checked[brand.id][type.id]"
                                   :value="brand.id"
                                   class="form-check-input">
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
    import {mapActions, mapGetters, mapState, mapMutations} from 'vuex';
    export default {
        props: ['auto_types', 'brands'],

        data() {
            return {
                checked: []
            }
        },
        created() {
            this.setAutoTypes(JSON.parse(this.auto_types));
            this.setAutoBrands(JSON.parse(this.brands));
            var types = {};

            for(let i = 0; i < this.autoTypes.length; i++) {
                types[this.autoTypes[i].id] = false;
            }

            for(let el in this.autoBrands) {
                this.checked[this.autoBrands[el].id] = types;
            }
        },
        computed: {
            selectAll: {
                get: function () {
                    return this.brands ? this.checked.length == this.autoBrands.length : false
                },
                set: function(value) {
                    return this.brands ? this.checked.length == this.autoBrands.length : false
                }
            },
            ...mapGetters({
                'autoTypes': 'autoTypes/getAutoTypes',
                'autoBrands': 'autoTypes/getAutoBrands'
            })
        },
        methods: {
            selectColumnAll(value, type) {
                console.log(value);
                var checked = [];
                var brands = this.autoBrands;

                if(value != undefined) {
                    this.autoBrands.map(function (brand) {
                        // checked[brand.id][type.id] = true;
                    });
                }
            },
            ...mapActions({
                'setAutoTypes': 'autoTypes/setAutoTypes',
                'setAutoBrands': 'autoTypes/setAutoBrands'
            })
        }
    }
</script>
