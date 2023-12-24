@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | المشرفين
@endsection
@section('page_name')
    المشرفين
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> اضافة ادمن {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('admin.store') }}">
                        @csrf
                        <input type="hidden" name="is_admin"/>
                        <div class="form-group">
                            <label for="name" class="form-control-label">الصورة</label>
                            <input type="file" class="dropify" name="image"
                                data-default-file="{{ asset('assets/uploads/avatar.png') }}"
                                accept="image/png,image/webp , image/gif, image/jpeg,image/jpg" />
                            <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif, jpeg,
                                jpg,webp</span>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-control-label">الاسم</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-control-label">Gmail : </label>
                            <input type="email" class="form-control" name="gmail" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-control-label">كلمة المرور</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('admin.index') }}" class="btn btn-info text-white">رجوع للخلف</a>
                            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    $('.dropify').dropify()
</script>
