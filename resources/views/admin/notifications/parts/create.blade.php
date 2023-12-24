@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | الاشعارات
@endsection
@section('page_name')
    الاشعارات
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> اضافة اشعار {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('notification.store') }}">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="user_id" class="form-control-label">مستخدم : </label>
                                    <select name="user_id" class="form-control">
                                        <option value="">كل المستخدمين</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="title" class="form-control-label">العنوان</label>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">الوصف</label>
                                    <textarea name="description" rows="8" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('notification.index') }}" class="btn btn-info text-white">رجوع للخلف</a>
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
