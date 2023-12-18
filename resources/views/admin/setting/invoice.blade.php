@extends('admin/layouts/master')

@section('title')
    {{($setting->name_en) ?? ''}} | اعدادات البوليصة
@endsection
@section('page_name')
    اعدادات البوليصة
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">اعدادات البوليصة</h3>
                </div>
                <div class="card-body">
                    <form id="updateForm" method="POST" enctype="multipart/form-data"
                          action="{{route('invoiceSettingUpdate',$invoice->id)}}">
                        @csrf
                        <input type="hidden" value="{{$invoice->id}}" name="id">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6 mt-5">
                                    <label for="name_ar" class="form-control-label">اسم الشركة بالعربية</label>
                                    <input type="text" class="form-control" value="{{ $invoice->company_name_ar }}"
                                           name="company_name_ar" id="name_ar" required>
                                </div>
                                <div class="col-6 mt-5">
                                    <label for="name_en" class="form-control-label">اسم الشركة بالانجليزية</label>
                                    <input type="text" class="form-control" value="{{ $invoice->company_name_en }}"
                                           name="company_name_en" id="name_ar" required>
                                </div>
                                <div class="col-6 mt-5">
                                    <label for="name_ar" class="form-control-label">عنوان الشركة بالعربية</label>
                                    <textarea type="text" class="form-control"
                                              name="location_ar" id="name_ar" required>{{ $invoice->location_ar }}</textarea>
                                </div>
                                <div class="col-6 mt-5">
                                    <label for="name_en" class="form-control-label">عنوان الشركة بالانجليزية</label>
                                    <textarea type="text" class="form-control"
                                              name="location_en" id="name_ar" required>{{ $invoice->location_en }}</textarea>
                                </div>

                                <div class="col-3 mt-5">
                                    <label for="name_en" class="form-control-label">صندوق البريد</label>
                                     <input type="text" class="form-control" value="{{ $invoice->po_box }}"
                                           name="po_box" id="name_ar" required>
                                </div>
                                <div class="col-3 mt-5">
                                    <label for="name_en" class="form-control-label">رقم السجل التجاري</label>
                                    <input type="number" class="form-control" value="{{ $invoice->cr_no }}"
                                           name="cr_no" id="name_ar" required>
                                </div>
                                <div class="col-3 mt-5">
                                    <label for="name_en" class="form-control-label">رقم الضريبي</label>
                                    <input type="number" class="form-control" value="{{ $invoice->vat_no }}"
                                           name="vat_no" id="name_ar" required>
                                </div>
                                <div class="col-3 mt-5">
                                    <label for="name_en" class="form-control-label"> ضريبة %</label>
                                    <input type="number" class="form-control" value="{{ $invoice->vat }}"
                                           name="vat" id="name_ar" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin/layouts/myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        $('.dropify').dropify()
        editScript();
    </script>
@endsection


