@extends('admin/layouts/master')

@section('title')
    {{($setting->name_en) ?? ''}} | الرسائل
@endsection
@section('page_name') الرسائل @endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> الرسائل {{($setting->name_en) ?? ''}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">الرابط</th>
                                <th class="min-w-50px">المستخدم</th>
                                <th class="min-w-125px">المدينة</th>
                                <th class="min-w-125px">الاهتمام</th>
                                <th class="min-w-125px">المحتوى</th>
                                <th class="min-w-50px rounded-end">العمليات</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin/layouts/myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'url', name: 'url'},
            {data: 'user_id', name: 'user_id'},
            {data: 'city_id', name: 'city_id'},
            {data: 'intrest_id', name: 'intrest_id'},
            {data: 'content', name: 'content'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('message.index')}}', columns);
    </script>
@endsection


