<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{route('adminHome')}}">
            <img src="{{  asset($settings->logo ?? '')}}"
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
            <a class="side-menu__item" href="{{ route('admin.index') }}">
                <i class="fa fa-home side-menu__icon"></i>
                <span class="side-menu__label">الادمن</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('package.index') }}">
                <i class="fa fa-home side-menu__icon"></i>
                <span class="side-menu__label">الباقات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('city.index') }}">
                <i class="fa fa-home side-menu__icon"></i>
                <span class="side-menu__label">المدن</span>
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

