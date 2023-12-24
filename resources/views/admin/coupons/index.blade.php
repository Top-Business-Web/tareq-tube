@extends('admin/layouts/master')

@section('title')
    {{($setting->name_en) ?? ''}} | الكوبونات
@endsection
@section('page_name') الكوبونات @endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> الكوبونات {{($setting->name_en) ?? ''}}</h3>
                    <a class="" href="{{ route('coupon.create') }}">
                        <button class="btn btn-secondary btn-icon text-white addBtn">
									<span>
										<i class="fe fe-plus"></i>
									</span> اضافة جديد
                        </button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">الكود</th>
                                <th class="min-w-50px">النقاط</th>
                                <th class="min-w-125px">المدة</th>
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
            {data: 'code', name: 'code'},
            {data: 'points', name: 'points'},
            {data: 'limit', name: 'limit'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('coupon.index')}}', columns);
    </script>
@endsection


