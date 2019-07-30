<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="ti-palette menu-icon"></i>
                <span class="menu-title">Товары</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.products.index') }}">Список</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="ti-palette menu-icon"></i>
                <span class="menu-title">Система импорта</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.import.index') }}">Система импорта</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.upload-history.index') }}">Отчеты</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="ti-package menu-icon"></i>
                <span class="menu-title">Каталог</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth" style="">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.catalog.index') }}">index</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.html">Товары</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.html">Диагностика</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.html">Настройки</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="ti-package menu-icon"></i>
                <span class="menu-title">Пользователи</span>
                <i class="menu-arrow"></i>
            </a>
            <div>
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.catalog.index') }}">Администраторы</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.html">Клиенты</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
