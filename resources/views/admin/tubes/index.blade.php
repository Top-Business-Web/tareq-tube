@extends('admin/layouts/master')

@section('title')
    {{($setting->name_en) ?? ''}} | قنوات المستخدمين
@endsection
@section('page_name') قنوات المستخدمين @endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> قنوات المستخدمين {{($setting->name_en) ?? ''}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">النوع</th>
                                <th class="min-w-50px">المستخدم</th>
                                <th class="min-w-125px">النفاط</th>
                                <th class="min-w-125px">الرابط </th> 
                                <th class="min-w-125px">عدد الاشتراكات</th>
                                <th class="min-w-125px">عدد الثواني</th>
                                <th class="min-w-125px">عدد المشاهدات</th>
                                <th class="min-w-125px">الهدف</th>
                                <th class="min-w-125px">الحالة</th>
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
            {data: 'type', name: 'type'},
            {data: 'user_id', name: 'user_id'},
            {data: 'points', name: 'points'},
            {data: 'url', name: 'url'},
            {data: 'sub_count', name: 'sub_count'},
            {data: 'second_count', name: 'second_count'},
            {data: 'view_count', name: 'view_count'},
            {data: 'target', name: 'target'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('tube.index')}}', columns);
    </script>
@endsection


