@extends('admin')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <h4>Новая категория</h4>
        </div>
    </div>
    <form action="{{ route('admin.auto.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="offset-md-10 col-md-2">
                                <button class="btn btn-success float-right">Сохранить</button>
                            </div>
                        </div>
                        <div class="row">
                            <auto-types-table
                                :auto_types="'{{ $auto_types }}'"
                                :brands="'{{ $brands }}'"
                            >

                            </auto-types-table>
{{--                            <table class="table">--}}

{{--                                <thead>--}}
{{--                                <th>Бренд</th>--}}
{{--                                @foreach($auto_types as $type)--}}
{{--                                    <th>{{ $type->title }}</th>--}}
{{--                                @endforeach--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach($brands as $brand)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{ $brand->name }}</td>--}}
{{--                                        @foreach($auto_types as $type)--}}
{{--                                            <td>--}}
{{--                                                <div class="form-check form-check-flat form-check-primary">--}}
{{--                                                    <label class="form-check-label">--}}
{{--                                                        <input type="checkbox" {{ isset($auto_brands[$brand->id]) && in_array($type->id, $auto_brands[$brand->id]) ? 'checked' : ''  }} name="auto_types[{{ $brand->id }}][{{ $type->id }}]"  class="form-check-input">--}}
{{--                                                        <i class="input-helper"></i>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        @endforeach--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
