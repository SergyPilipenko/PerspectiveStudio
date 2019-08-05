@extends('admin')
@section('content')
    <div class="row">

    <div class="col-md-4">
            <label for="uploadType">Источник:</label>
            <select name="uploadType" id="uploadType" class="form-control">
                <option value="App\Models\Admin\Import\ImportByUrl" {{ $import_setting->importable_type == 'App\Models\Admin\Import\ImportByUrl' ? 'selected' : '' }}>HTTP</option>
                <option value="App\Models\Admin\Import\ImportByFile" {{ $import_setting->importable_type == 'App\Models\Admin\Import\ImportByFile' ? 'selected' : '' }}>Загрузка с компьютера</option></select>
        </div>
    </div>
    <div class="row m-t-20"><div class="col-md-4">
            <label for="importFileTitle">
                <span class="required" >Название</span>
                <input type="text" id="importFileTitle" class="form-control form-control" value="{{ $import_setting->title }}">
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table importFileTable">
                <table>
                    <thead>
                    <tr>
                        @foreach(json_decode($import_setting->scheme) as $item)
                            <th scope="col">
                                    <select name="columnType[]" class="form-control">
                                        <option value=""> - выбрать поле - </option>
                                        @foreach($options as $key => $option)
                                            <option value="{{ $key }}" {{ $item->value == $key ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                            </th>
                        @endforeach

                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="row m-t-20">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">

                    </div>
{{--                    <parser--}}
{{--                            :routes="'{{ $routes }}'"--}}
{{--                    ></parser>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
