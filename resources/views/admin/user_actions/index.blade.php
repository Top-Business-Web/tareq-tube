@extends('admin/layouts/master')

@section('title')
    {{($setting->name_en) ?? ''}} | تفاعل المستخدمين
@endsection
@section('page_name') تفاعل المستخدمين @endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> تفاعل المستخدمين {{($setting->name_en) ?? ''}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">المستخدم</th>
                                <th class="min-w-50px">اسم القناة</th>
                                <th class="min-w-125px">النوع</th>
                                <th class="min-w-125px">الحالة</th>
                                <th class="min-w-125px">النقاط</th>
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
            {data: 'user_id', name: 'user_id'},
            {data: 'tube_id', name: 'tube_id'},
            {data: 'type', name: 'type'},
            {data: 'status', name: 'status'},
            {data: 'points', name: 'points'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('userAction.index')}}', columns);
    </script>
@endsection


