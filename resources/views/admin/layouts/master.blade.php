<!doctype html>
<html lang="ar" dir="rtl">

<head>
    @include('admin/layouts/head')
</head>

<body class="app sidebar-mini">

<!-- Start Switcher -->
{{--@include('admin/layouts/switcher')--}}
<!-- End Switcher -->

<!-- GLOBAL-LOADER -->
@include('admin/layouts/loader')
<!-- /GLOBAL-LOADER -->

<!-- PAGE -->
<div class="page">
    <div class="page-main">
        <!--APP-SIDEBAR-->
        @include('admin/layouts/main-sidebar')
        <!--/APP-SIDEBAR-->

        <!-- Header -->
        @include('admin/layouts/main-header')
        <!-- Header -->
        <!--Content-area open-->
        <div class="app-content">
            <div class="side-app">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <div>
                        <h1 class="page-title">مرحبا بـك ! <i class="fas fa-heart text-danger"></i></h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('adminHome')}}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('page_name')</li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->
                @yield('content')
            </div>
            <!-- End Page -->
        </div>
        <!-- CONTAINER END -->
    </div>
    <!-- SIDE-BAR -->

    <!-- FOOTER -->
    @include('admin/layouts/footer')
    <!-- FOOTER END -->
</div>
<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up mt-4"></i></a>

@include('admin/layouts/scripts')
<?php
$checkKeysCount = \App\Models\YoutubeKey::query()
    ->where('limit', '<', 9900)
    ->count();
?>
<script>
    @if(Route::currentRouteName() != 'youtube_key.index' && Route::currentRouteName() != 'youtube_key.create')
        function playWarning() {
            var x = new Audio("{{ asset('assets/wrong-answer-129254.mp3') }}");

            x.play();

            var notyf = new Notyf({
                duration: 6000,
                position: {
                    x: 'center',
                    y: 'center',
                },
            });
            const notification = notyf.success('باقي مفتاح واحد فقط يجب اضافة يوتيوب API اضغط هنا للاضافة');
            notification.on('click', ({target, event}) => {
                // target: the notification being clicked
                // event: the mouseevent
                window.location.href = '{{ route('youtube_key.index') }}';
            });

        } // end playAudio
            @if ($checkKeysCount <= 1)
            setInterval(function () {
                playWarning();
            }, 3000)
            @endif
    @endif
</script>
@yield('ajaxCalls')
</body>
</html>
