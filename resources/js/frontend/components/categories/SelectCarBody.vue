<template>
    <div>
        <div>
            <label for="year" v-if="!yearSelected"></label>
            <select name="year"
                    v-model="yearSelected" class="form-control"
                    @change="setCarYear({action: route['set-car-year'], yearSelected: yearSelected})">
                <option value="">Не выбрано</option>
                <option :value="year" v-for="year in rangeYears" v-text="year"></option>
            </select>
        </div>
        <select name="" class="form-control">
            <option value="">test</option>
        </select>
        <select name="" class="form-control">
            <option value="">test</option>
        </select>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        props: ['year', 'actions'],
        data() {
            return {
                yearSelected: this.year,
                rangeYears: [],
                route: JSON.parse(this.actions)
            }
        },
        created() {
            let first = this.years[0];
            while (first <= this.years[1]) {
                this.rangeYears.push(first);
                first++;
            }
        },

        computed: {
            ...mapGetters({
                years: 'selectCar/getYears',
            })
        },

        methods: {
            ...mapActions({
                setCarYear: 'selectCar/setCarYear'
            }),
        }
    }
</script>
