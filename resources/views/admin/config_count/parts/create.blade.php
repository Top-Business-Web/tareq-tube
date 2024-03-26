@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | اسعار العمليات
@endsection
@section('page_name')
    اسعار العمليات
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> اضافة سعر عملية {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('config_count.store') }}">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="type" value="{{ $type }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="count" class="form-control-label">العدد : </label>
                                    <input type="number" class="form-control" name="count" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="point" class="form-control-label">النقاط</label>
                                    <input type="number" class="form-control" name="point" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('config_count.index',['type'=>$type]) }}" class="btn btn-info text-white">رجوع للخلف</a>
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
