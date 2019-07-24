@extends('admin')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0">Настройки</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <catalog-settings
                            :import_setting="{{ $import_setting }}"
                            :routes="{{ $routes }}"
                            :file_import_price_action="'{{ route('admin.import.price', $import_setting) }}'"
                            :update_action="'{{ route('admin.catalog.update', $import_setting) }}'"
                            :destroy_action="'{{ route('admin.catalog.destroy', $import_setting) }}'"
                    ></catalog-settings>
                    <form action="">
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection