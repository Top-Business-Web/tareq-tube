@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | الاعدادات
@endsection
@section('page_name')
    الاعدادات
@endsection
@section('content')
    <style>
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 200px;
        }

        .ck-content .image {
            /* block images */
            max-width: 80%;
            margin: 20px auto;
        }
    </style>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> اعدادات {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data"
                          action="{{ route('setting.update') }}">
                        @csrf
                        <input type="hidden" value="{{ $settingData['id'] }}" name="id">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label for="name" class="form-control-label">اللوجو</label>
                                    <input type="file" class="dropify" name="logo"
                                           data-default-file="{{ asset($settingData['logo']) }}" value=""
                                           accept="image/png,image/webp , image/gif, image/jpeg,image/jpg"/>
                                    <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif,jpeg, jpg,webp</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name_ar" class="form-control-label">الهاتف</label>
                                    <input type="text" class="form-control" value="{{ $settingData['phone'] }}"
                                           name="phone" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name_en" class="form-control-label">حد المستخدم</label>
                                    <input type="number" class="form-control" value="{{ $settingData['limit_user'] }}"
                                           name="limit_user" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name_ar" class="form-control-label">نقاط المستخدم</label>
                                    <input type="number" class="form-control" value="{{ $settingData['point_user'] }}"
                                           name="point_user" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="name_en" class="form-control-label">ضريبة القيمة المضافة</label>
                                    <input type="number" class="form-control" value="{{ $settingData['vat'] }}"
                                           name="vat" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="name_en" class="form-control-label">الحد للسحب</label>
                                    <input type="number" class="form-control"
                                           value="{{ $settingData['limit_balance'] }}"
                                           name="limit_balance" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name_ar" class="form-control-label">نقاط السعر</label>
                                    <input type="number" class="form-control" value="{{ $settingData['point_price'] }}"
                                           name="point_price" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name_en" class="form-control-label">سعر الرمز المميز</label>
                                    <input type="number" class="form-control" value="{{ $settingData['token_price'] }}"
                                           name="token_price" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name_ar" class="form-control-label">الخصوصية</label>
                                    <textarea class="form-control" row="8">{{ $settingData['privacy'] }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--    @include('admin/layouts/myAjaxHelper')--}}
@endsection
@section('ajaxCalls')
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"--}}
    {{--        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="--}}
    {{--        crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
    {{----}}
    <script>
        $('.dropify').dropify()
        {{--        editScript();--}}
    </script>
@endsection
