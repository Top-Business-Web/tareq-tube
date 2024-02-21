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
                <i class="fa fa-user-secret side-menu__icon"></i>
                <span class="side-menu__label">الادمن</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('users.index') }}">
                <i class="fa fa-users side-menu__icon"></i>
                <span class="side-menu__label">المستخدمين</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('package.index') }}">
                <i class="fa fa-cube side-menu__icon"></i>
                <span class="side-menu__label">الباقات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('city.index') }}">
                <i class="fa fa-city side-menu__icon"></i>
                <span class="side-menu__label">المدن</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('interest.index') }}">
                <i class="fa fa-heart side-menu__icon"></i>
                <span class="side-menu__label">الاهتمامات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('package_user.index') }}">
                <i class="fa fa-users side-menu__icon"></i>
                <span class="side-menu__label">باقات المستخدمين</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('config_count.index') }}">
                <i class="fa fa-dollar-sign side-menu__icon"></i>
                <span class="side-menu__label">اسعار العمليات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('slider.index') }}">
                <i class="fa fa-image side-menu__icon"></i>
                <span class="side-menu__label">الصورة المتحركة</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('message.index') }}">
                <i class="fa fa-paper-plane side-menu__icon"></i>
                <span class="side-menu__label">الرسائل</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('notification.index') }}">
                <i class="fa fa-comment side-menu__icon"></i>
                <span class="side-menu__label">الاشعارات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('coupon.index') }}">
                <i class="fa fa-money-bill side-menu__icon"></i>
                <span class="side-menu__label">الكوبونات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('userAction.index') }}">
               <i class="fa fa-user side-menu__icon"></i>
                <span class="side-menu__label">تفاعل المستخدمين</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('tube.index') }}">
                <i class="fa fa-tv side-menu__icon"></i>
                <span class="side-menu__label"> قنوات المستخدمين</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('modelPrice.index') }}">
                <i class="fa fa-credit-card side-menu__icon"></i>
                <span class="side-menu__label"> اسعار الباقات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('withdraw.index') }}">
                <i class="fa fa-credit-card side-menu__icon"></i>
                <span class="side-menu__label"> طلبات سحب الرصيد</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('payment-transaction.index') }}">
                <i class="fa fa-money-check side-menu__icon"></i>
                <span class="side-menu__label">معاملات الدفع</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('setting.index') }}">
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

