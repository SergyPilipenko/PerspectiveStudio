@extends('admin')
@section('content')
    <div class="card">
        <form action="{{ route('admin.settings.locales.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row card-control-header">
                    <div class="col-md-10">
                        <h3>Новая локализация</h3>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success float-right">Создать</button>
                    </div>
                </div>
                <div class="v-cloak--hidden">
                    <accordian>
                        <div slot="header">Общее</div>
                        <div slot="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label for="code">Код</label>
                                        <input type="text" name="code" id="code"
                                               value="{{ old('code') ?? '' }}"
                                               class="form-control {{ ValidationHelper::errorExists($errors, 'code') ? 'error' : '' }}">
                                        @include('admin.partials.input-errors', ['input_name' => 'code'])
                                    </div>
                                    <div class="form-group required">
                                        <label for="name">Название</label>
                                        <input type="text" name="name" id="name"
                                               value="{{ old('name') ?? '' }}"
                                               class="form-control {{ ValidationHelper::errorExists($errors, 'name') ? 'error' : '' }}">
                                        @include('admin.partials.input-errors', ['input_name' => 'name'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordian>
                </div>
            </div>
        </form>
    </div>
@endsection
