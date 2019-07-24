<template>
    <div>

        <div>
            <a href="#" v-b-modal.modal-center>Кросс номера</a>

            <b-modal id="modal-center" centered title="BootstrapVue">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="submit" value="Добавить" class="btn btn-block btn-primary">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex flex-row flex-wrap crosses-container">
                        <span class="badge badge-secondary " v-for="cross in crosses" v-text="cross">Secondary</span>
                    </div>
                </div>
            </b-modal>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                crosses: ['456-67-908', 'A3568', '89-878778.654', '8dfg556', 'A3568', '89-878778.654', '8dfg556', 'A3568', '89-878778.654', '8dfg556', 'A3568', '89-878778.654', '8dfg556']
            }
        }
    }
</script>

<style>
    .crosses-container span {
        margin-right: 10px;
    }
</style>