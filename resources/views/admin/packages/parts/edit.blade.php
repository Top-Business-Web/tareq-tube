@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | الباقات
@endsection
@section('page_name')
    الباقات
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> تعديل باقة {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('package.update', $packageData['id']) }}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name" class="form-control-label">اسم الباقة</label>
                            <input الباقاتtype="text" class="form-control" value="{{ $packageData['name'] }}" name="name" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="price" class="form-control-label">السعر : </label>
                                    <input type="text" class="form-control" value="{{ $packageData['price'] }}" name="price" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="days" class="form-control-label">الايام</label>
                                    <input type="text" class="form-control" value="{{ $packageData['days'] }}" name="days" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('package.index') }}" class="btn btn-info text-white">رجوع للخلف</a>
                            <button type="submit" class="btn btn-primary" id="addButton">تعديل</button>
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