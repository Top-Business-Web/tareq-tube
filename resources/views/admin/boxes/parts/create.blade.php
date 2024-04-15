@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | الصناديق اليومية
@endsection
@section('page_name')
    الصناديق اليومية
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> اضافة صناديق يومية {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('city.store') }}">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name" class="form-control-label">اسم مدينة</label>
                                    <input الباقاتtype="text" class="form-control" name="name" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('city.index') }}" class="btn btn-info text-white">رجوع للخلف</a>
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
