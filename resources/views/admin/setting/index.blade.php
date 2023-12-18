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
                    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('settingUpdate',$settings->id)}}">
                        @csrf
                        <input type="hidden" value="{{ $settings->id }}" name="id">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label for="name" class="form-control-label">اللوجو</label>
                                    <input type="file" class="dropify" name="logo" data-default-file="{{ asset($settings->logo) }}" value=""
                                        accept="image/png,image/webp , image/gif, image/jpeg,image/jpg" />
                                    <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif,
                                        jpeg, jpg,webp</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name_ar" class="form-control-label">سعر الكيلومتر</label>
                                    <input type="number" class="form-control" value="{{ $settings->km }}" name="km" id="km"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name_en" class="form-control-label">ضريبة القيمة المضافة</label>
                                    <input type="number" class="form-control" value="{{ $settings->vat }}" name="vat" id="vat"
                                        required>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12">
                                <label for="details_ar" class="form-control-label">تأمين الرحلة</label>
                                <textarea class="form-control" name="trip_insurance" id="trip_insurance" required>{{ $settings->trip_insurance }}</textarea>
                                <label for="details_en" class="form-control-label">المكافآت</label>
                                <textarea class="form-control" name="rewards" id="rewards" required>{{ $settings->rewards }}</textarea>
                                <label for="details_en" class="form-control-label">ماذا عنا</label>
                                <textarea class="form-control" name="about" id="about" required>{{ $settings->about }}</textarea>
                                <label for="details_en" class="form-control-label">الدعم</label>
                                <textarea class="form-control" name="support" id="support" required>{{ $settings->support }}</textarea>
                                <label for="details_en" class="form-control-label">أدوار السلامة</label>
                                <textarea class="form-control" name="safety_roles" id="safety_roles" required>{{ $settings->safety_roles }}</textarea>
                                <label for="details_en" class="form-control-label">السياسات</label>
                                <textarea class="form-control" name="polices" id="polices" required>{{ $settings->polices }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    </div>about
    @include('admin/layouts/myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script src="{{ asset('assets/ck5/ckeditor.js') }}"></script>

    <script>
        ClassicEditor.create(document.querySelector('#trip_insurance'));
        ClassicEditor.create(document.querySelector('#rewards'));
        ClassicEditor.create(document.querySelector('#about'));
        ClassicEditor.create(document.querySelector('#support'));
        ClassicEditor.create(document.querySelector('#safety_roles'));
        ClassicEditor.create(document.querySelector('#polices'));
    </script>

    <script>
        $('.dropify').dropify()
        editScript();
    </script>
@endsection