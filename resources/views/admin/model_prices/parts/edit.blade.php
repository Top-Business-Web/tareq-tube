@extends('admin/layouts/master')

@section('title')
{{ $setting->name_en ?? '' }} | اسعار الباقات
@endsection
@section('page_name')
اسعار الباقات
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> اضافة سعر باقة {{ $setting->name_en ?? '' }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('modelPrice.update', $modelPriceData['id']) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name" class="form-control-label">نوع الباقة</label>
                                <select class="form-control" name="type">
                                    <option value="" selected>Choose</opion>
                                    <option value="msg" {{ $modelPriceData['type'] == 'msg' ? 'selected' : '' }}>Message</option>
                                    <option value="points" {{ $modelPriceData['type'] == 'points' ? 'selected' : '' }}>Points</option>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-control-label">العدد</label>
                                <input type="number" class="form-control" value="{{ $modelPriceData['count'] }}" name="count" />
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-control-label">السعر</label>
                                <input type="number" class="form-control" value="{{ $modelPriceData['price'] }}" name="price" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('modelPrice.index') }}" class="btn btn-info text-white">رجوع للخلف</a>
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
