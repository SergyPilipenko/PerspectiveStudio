<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#catalogs" aria-expanded="false" aria-controls="catalogs">
                <i class="ti-package menu-icon"></i>
                <span class="menu-title">Каталог</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="catalogs" style="">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.catalog.products.index') }}">Товары</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.catalog.categories.create') }}">Категории</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.catalog.attributes.index') }}">Атрибуты</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.catalog.attribute-families.index') }}">Наборы атрибутов</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#content" aria-expanded="false" aria-controls="catalogs">
                <i class="ti-layout menu-icon"></i>
                <span class="menu-title">Контент</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="content" style="">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.content.rubrics.index') }}">Рубрики</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.content.blocks.index') }}">Блоки</a></li>
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.catalog.index') }}">Загрузки</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.tecdoc.categories.create') }}">Категории</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.products.index') }}">Товары</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.auto.index') }}">Автомобили</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.tecdoc.suppliers-countries.index') }}">Страны производителей</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
                <i class="ti-settings menu-icon"></i>
                <span class="menu-title">Настройки</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="settings" style="">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.settings.locales.index') }}">Локализации</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
