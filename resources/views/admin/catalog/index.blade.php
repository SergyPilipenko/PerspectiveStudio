@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Название
                                </th>
                                <th>
                                    Товары
                                </th>
                                <th>
                                    Статус
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($settings as $setting)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input">
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.catalog.show', $setting->id) }}">{{ $setting->title }}</a>
                                        </td>
                                        <td>{{ $setting->pricesCount }}</td>
                                        <td>
                                            <div >2 предупреждения</div>
                                            @if($setting->importErrors->count())
                                                <div class="text-danger">
                                                    <a href="{{ route('admin.catalog.errors', $setting) }}">{{ $setting->importErrors->count() }} ошибок</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection