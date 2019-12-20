@extends('frontend')
@section('content')
    <div class="container">
        <h1>Первое приложение!</h1>
        <p>
            <!-- используем компонент router-link для навигации -->
            <!-- входной параметр `to` определяет URL для перехода -->
            <!-- `<router-link>` по умолчанию отображается тегом `<a>` -->
            <router-link to="/foo">Перейти к Foo</router-link>
            <router-link to="/bar">Перейти к Bar</router-link>
        </p>
        <!-- отображаем тут компонент, для которого совпадает маршрут -->
        <router-view></router-view>
    </div>
@endsection
