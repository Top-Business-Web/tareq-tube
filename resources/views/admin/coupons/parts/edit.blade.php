@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | الكوبونات
@endsection
@section('page_name')
الكوبونات
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> تعديل كوبون {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('coupon.update', $couponData['id']) }}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name" class="form-control-label">اسم الكوبون</label>
                            <input type="text" class="form-control" value="{{ $couponData['code'] }}" name="code" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="points" class="form-control-label">النقاط : </label>
                                    <input type="number" class="form-control" value="{{ $couponData['points'] }}" name="points" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="limit" class="form-control-label">المدة</label>
                                    <input type="number" class="form-control" value="{{ $couponData['limit'] }}" name="limit" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('coupon.index') }}" class="btn btn-info text-white">رجوع للخلف</a>
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