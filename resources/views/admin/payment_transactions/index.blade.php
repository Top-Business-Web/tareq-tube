@extends('admin/layouts/master')

@section('title')
    {{ $setting->name_en ?? '' }} | معاملات الدفع
@endsection
@section('page_name')
    معاملات الدفع
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> معاملات الدفع {{ $setting->name_en ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                                <tr class="fw-bolder text-muted bg-light">
                                    <th class="min-w-25px">#</th>
                                    <th class="min-w-50px">المستخدم</th>
                                    <th class="min-w-50px">عملية الدفع</th>
                                    <th class="min-w-50px">الحالة</th>
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
        var columns = [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'user_id',
                name: 'user_id'
            },
            {
                data: 'payment_id',
                name: 'payment_id'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
        showData('{{ route('payment-transaction.index') }}', columns);
    </script>
@endsection
