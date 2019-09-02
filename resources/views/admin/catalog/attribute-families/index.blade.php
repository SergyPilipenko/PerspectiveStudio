@extends('admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row card-control-header">
                <div class="col-md-10">
                    <h3>Наборы аттрибутов</h3>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.catalog.attribute-families.create') }}" class="btn btn-primary float-right">Добавить</a>
                </div>
            </div>
            <div class="v-cloak--hidden">
                <accordian>
                    <div slot="header">Общее</div>
                    <div slot="body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label for="code">Код аттрибута</label>
                                    <input type="text" id="code"
                                           name="code"
                                           value="{{ old('code') ?? '' }}"
                                           class="form-control {{ ValidationHelper::errorExists($errors, 'code') ? 'error' : '' }}">
                                    @include('admin.partials.input-errors', ['input_name' => 'code'])
                                </div>
                                <div class="form-group required">
                                    <label for="name">Название</label>
                                    <input type="text" id="name"
                                           name="name"
                                           value="{{ old('name') ?? '' }}"
                                           class="form-control {{ ValidationHelper::errorExists($errors, 'name') ? 'error' : '' }}">
                                    @include('admin.partials.input-errors', ['input_name' => 'name'])
                                </div>
                            </div>
                        </div>
                    </div>
                </accordian>
                <attribute-groups :action="'{{ route('admin.catalog.attribute-families.attribute-groups.store') }}'"></attribute-groups>

            </div>
        </div>
    </div>
@endsection
