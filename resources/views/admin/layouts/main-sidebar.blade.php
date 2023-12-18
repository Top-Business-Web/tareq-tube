<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{route('adminHome')}}">
            <img src="{{  asset($settings->logo)}}"
                 class="header-brand-img light-logo1" alt="logo">
        </a>
        <!-- LOGO -->
    </div>
    <ul class="side-menu">
        <li><h3>العناصر</h3></li>
        <li class="slide">
            <a class="side-menu__item" href="{{route('adminHome')}}">
                <i class="fa fa-home side-menu__icon"></i>
                <span class="side-menu__label">الرئيسية</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{route('admins.index')}}">
                <i class="fa fa-users side-menu__icon"></i>
                <span class="side-menu__label">المشرفين</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('userPerson.index') }}">
                <i class="fa fa-users side-menu__icon"></i>
                <span class="side-menu__label">المستخدمين</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('driver.index')}}">
                <i class="fa fa-car side-menu__icon"></i>
                <span class="side-menu__label">السائقين</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('city.index')}}">
                <i class="fa fa-city side-menu__icon"></i>
                <span class="side-menu__label">المدن</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('area.index')}}">
                <i class="fa fa-city side-menu__icon"></i>
                <span class="side-menu__label">المناطق</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="fa fa-truck side-menu__icon"></i>
                <span class="side-menu__label">الرحلات</span><i class="angle fa fa-angle-left"></i>
            </a>
            <ul class="slide-menu">

                <li><a href="{{ route('trip.complete') }}" class="slide-item">مكتملة</a></li>
                <li><a href="{{ route('trip.new') }}" class="slide-item">جديدة</a></li>
                <li><a href="{{ route('trip.reject') }}" class="slide-item">مرفوضة</a></li>

            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('slider.index')}}">
                <i class="fa fa-image side-menu__icon"></i>
                <span class="side-menu__label">صور متحركة</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('driver_document.index')}}">
                <i class="fa fa-book side-menu__icon"></i>
                <span class="side-menu__label">وثائق السائق</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('notifications.index')}}">
                <i class="fa fa-bell side-menu__icon"></i>
                <span class="side-menu__label">الاشعارات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('settingIndex')}}">
                <i class="fa fa-wrench side-menu__icon"></i>
                <span class="side-menu__label">الاعدادات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{route('admin.logout')}}">
                <i class="fa fa-lock side-menu__icon"></i>
                <span class="side-menu__label">تسجيل الخروج</span>
            </a>
        </li>

    </ul>
</aside>

