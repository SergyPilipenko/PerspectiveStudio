<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">--}}
{{--                <i class="ti-palette menu-icon"></i>--}}
{{--                <span class="menu-title">Товары</span>--}}
{{--                <i class="menu-arrow"></i>--}}
{{--            </a>--}}
{{--            <div class="collapse" id="ui-basic">--}}
{{--                <ul class="nav flex-column sub-menu">--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.products.index') }}">Список</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </li>--}}
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="ti-package menu-icon"></i>
                <span class="menu-title">Каталог</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth" style="">
                <ul class="nav flex-column sub-menu">
{{--                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.catalog.index') }}">Товары</a></li>--}}
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.catalog.categories.create') }}">Категории</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#import-system" aria-expanded="false" aria-controls="import-system">
                <i class="ti-palette menu-icon"></i>
                <span class="menu-title">Система импорта</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="import-system">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.import.index') }}">Схемы</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#tecdoc" aria-expanded="false" aria-controls="tecdoc">
                <i class="ti-package menu-icon"></i>
                <span class="menu-title">Tecdoc</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tecdoc" style="">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.catalog.index') }}">Загрузки</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.tecdoc.categories.create') }}">Категории</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.products.index') }}">Товары</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.auto.index') }}">Автомобили</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
