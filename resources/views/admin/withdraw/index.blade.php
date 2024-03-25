@extends('admin/layouts/master')

@section('title')
    {{($setting->name_en) ?? ''}} | طلبات سحب الرصيد
@endsection
@section('page_name') طلبات سحب الرصيد @endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> طلبات سحب الرصيد {{($setting->name_en) ?? ''}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">اسم العميل</th>
                                <th class="min-w-50px">رقم فودافون كاش</th>
                                <th class="min-w-50px">المبلغ المراد تحويله (ج.م)</th>
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
            {data: 'phone', name: 'phone'},
            {data: 'price', name: 'price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('withdraw.index')}}', columns);
    </script>
@endsection


