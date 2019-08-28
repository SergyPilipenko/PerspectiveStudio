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
                    <div class="">
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
                    <input type="checkbox" name="auto_types[][]"
                           v-model="checked[brand.id][type.id]"
                           class="form-check-input">
                    <i class="input-helper"></i>
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
                checked: {}
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
                var checked = [];
                for(let el in this.checked) {
                    checked[el] = this.checked[el];
                    checked[el][type.id] = !checked[el][type.id];
                }
                this.$set(this, 'checked', checked);
            },
            ...mapActions({
                'setAutoTypes': 'autoTypes/setAutoTypes',
                'setAutoBrands': 'autoTypes/setAutoBrands'
            })
        }
    }
</script>
