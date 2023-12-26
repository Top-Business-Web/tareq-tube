@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | الصورة المتحركة
@endsection
@section('page_name')
    الصورة المتحركة
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> تعديل الصورة المتحركة {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('slider.update', $sliderData['id']) }}">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name" class="form-control-label">الصورة</label>
                                    <input type="file" class="dropify" name="image"
                                        data-default-file="{{ asset('storage/' .$sliderData['image']) }}"
                                        accept="image/png,image/webp , image/gif, image/jpeg,image/jpg" />
                                    <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif,
                                        jpeg,
                                        jpg,webp</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="url" class="form-control-label">الرابط : </label>
                                    <input type="text" class="form-control" value="{{ $sliderData['url'] }}" name="url" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('slider.index') }}" class="btn btn-info text-white">رجوع للخلف</a>
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