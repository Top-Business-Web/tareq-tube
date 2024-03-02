@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | API Key
@endsection
@section('page_name')
API Key
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> اضافة API Key {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('youtube_key.store') }}">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="key" class="form-control-label">Key</label>
                                    <input type="text" class="form-control" name="key" required>
                                    <input type="hidden" class="form-control" name="limit" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('youtube_key.index') }}" class="btn btn-info text-white">رجوع للخلف</a>
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
