<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>invoice</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/invoice') }}/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/invoice') }}/css/bootstrap.min.css">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&family=Jost:wght@200;300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .title-inside{
            border: 1px solid black;
            text-align: left;
            padding-left: 10px;
        }
        .change-width{
            height: 190px;
        }
        p{
            margin-bottom: 5px;
        }
        .border{
            border: 1px solid black !important;
        }
        .box-signature{
            width: 200px;
            height: 70px;
            border: 2px solid black;
        }
        @media print{
            body{
                font-size: 10px;
            }
            h6{
                font-size: 10px;
            }
            p,h6,table{
                margin-bottom: 0px !important;
            }
            .change-width{
                height: 100px;
            }
        }

    </style>
</head>
<body>

<div class="invoice">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h6>فاتورة ضريبية.</h6>
                <h6>{{ $invoice->company_name_ar }}</h6>
                <p>{{ $invoice->location_ar }}</p>
                <p> صندوق بريد: {{ $invoice->po_box }}</p>
                <p>رقم السجل التجارى: {{ $invoice->cr_no }}</p>
                <p>رقم الضريبى: {{ $invoice->vat_no }}</p>
            </div>
            <div class="col-4 d-flex justify-content-center align-items-center">
                <h6>simplified tax invoice <br> consignment No :</h6>
            </div>
            <div class="col-4 text-start">
                <h6>{{ $invoice->company_name_en }}</h6>
                <p>{{ $invoice->location_en }}</p>
                <p>P.O Box: {{ $invoice->po_box }}</p>
                <p>CR No: {{ $invoice->cr_no }}</p>
                <p>VAT No. : {{ $invoice->vat_no }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="title-inside mb-1">
                    <h6>تاريخ الفاتورة / invoice date</h6>
                </div>
                <div class="title-inside">
                    <h6> التوصيل special delivery</h6>
                </div>
                <div class="title-inside">
                    <div class="row p-2">
                        <div class="col-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" >
                                <label class="form-check-label" for="flexCheckDefault">
                                    من الناقل
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                                <label class="form-check-label" for="flexCheckChecked">
                                    من الباب الى الباب
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <p>office delivery</p>
                            <p>door to door</p>
                            <p>values of goods</p>
                            <p>قيمة البضاعة</p>
                            <p>delivery cost</p>
                            <p>تكلفة التوصيل</p>
                        </div>
                        <div class="col-3 d-flex justify-content-center">
                            {!! QrCode::size(50)->generate(route('orderShow',$offer->order_id)) !!}
                        </div>
                    </div>
                </div>
                <div class="title-inside mt-1 mb-1">
                    <h6> تفاصيل المتلقى receiver`s details</h6>
                </div>
                <div class="title-inside mb-1">
                    <h6> اسم / name </h6>
                    <h6> شركة / company</h6>
                    <h6> العنوان / address</h6>
                    <h6> مساحة / area</h6>
                    <h6> رقم الاتصال / contact no</h6>
                    <h6> مدينة / city</h6>
                    <h6> بلد / country</h6>
                    <h6> الرقم الضريبى / vat no</h6>
                    <h6> رقم الهوية / ID no</h6>
                </div>
            </div>
            <div class="col-6">
                <div class="title-inside mb-1">
                    <h6>رقم الفاتورة / invoice No</h6>
                </div>
                <div class="title-inside">
                    <h6> طريقة الدفع payment method</h6>
                </div>
                <div class="title-inside change-width">
                    <div class="row p-2">
                        <div class="col-6">
                            <p class="mb-1"> ادفع نقدا</p>
                            <p class="mb-1">الدفع عند الاستلام</p>
                            <p>حوالة بنكية</p>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    cash
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"  value="" id="flexCheckChecked" >
                                <label class="form-check-label" for="flexCheckChecked">
                                    COD
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"  value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    bank transfer
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title-inside mt-1 mb-1">
                    <h6> تفاصيل المرسل sender`s details</h6>
                </div>
                <div class="title-inside mb-1">
                    <h6> اسم / name </h6>
                    <h6> شركة / company</h6>
                    <h6> العنوان / address</h6>
                    <h6> مساحة / area</h6>
                    <h6> رقم الاتصال / contact no</h6>
                    <h6> مدينة / city</h6>
                    <h6> بلد / country</h6>
                    <h6> الرقم الضريبى / vat no</h6>
                    <h6> رقم الهوية / ID no</h6>
                </div>
            </div>
        </div>
        <table class="table border">
            <tbody>
            <tr>
                <td class="border text-center fw-bold">المجموع<br> amount</td>
                <td class="text-center fw-bold">ضريبة <br> vat 15%</td>
                <td class="border text-center fw-bold">خصم <br> discount</td>
                <td class="text-center fw-bold">وحدة <br> unit</td>
                <td class="border text-center fw-bold">كمية <br> Qty</td>
                <td class="text-center fw-bold">بيانات الارسال <br>item&description</td>
                <td class="border text-center fw-bold">رقم التسلسل <br> sl</td>
            </tr>
            <tr>
                <td class="border"></td>
                <td></td>
                <td class="border"></td>
                <td></td>
                <td class="border"></td>
                <td></td>
                <td class="border"></td>
            </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-6">
                <div class="title-inside mb-1">
                    <p>(باستثناء ضريبةالقيمة المضافة) total(Excluding vat)</p>
                    <p>الاجمالى</p>
                    <p> خصم discount</p>
                    <p>total(excluding vat)</p>
                    <p>الاجمالى(باستثناء ضريبة القيمة المضافة)</p>
                    <p>المجموع total vat (15%) vat</p>
                    <h6> اجمالى المبلغ المستحق total amount due</h6>
                </div>
            </div>
            <div class="col-6">
                <div class="title-inside mb-1 change-width">
                    <h6> Note </h6>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between bg-black text-white pe-3 ps-3 pb-2">
            <h6>شروط واحكام النقل</h6>
            <h6>transportation terms & conditions</h6>
        </div>
        <div class="row">
            <div class="col-6">
                1-يحظر شحن النقود والذهب والادوية وما ينص النظام على منعه
                <br>
                2-الناقل غير مسئول عن اى اضرار او تلف لا بضاعة قابلة للكسر اثناء التحميل او الحوادث المرورية او الحريق او الكوارث الطبيعية
                <br>
                3-أقصى تعويض عن فقدان اى ارسالية قيمة الارسالية الخاصة بناقل او بحد اقصى (100) مائة ريال ما لم يتفق على غير ذلك
                <br>
                4- النقل غير مسئول عن محتوى اى ارسالية
                <br>
                5- الناقل غير مسئول عن اى ارسالية لم يستلمها المرسل اليه ولم يستقبلها المرسل بعد مرور 21 احدى وعشرون يوما
                <br>
                6- استلام وتوقيع نسخة الوثيقة قبولا بكافة شروط النقل
                <br>
                7- الحق فى تعليق اى ارساليات يتضح الناقل انها تنتهك شروط النقل
                <br>
                8- مدة النقل المتفق عليها خمسة ايام ولا يحق للمرسل تقديم شكوى قبل تلك الفترة
            </div>
            <div class="col-6" style="direction: ltr;">
                1- it is forbidden to ship cash, gold and medicines, what the system stipulates is impermissible
                <br>
                2- the carrier is not responsible for any damage or damage to any goods subject to breakage during loading, traffic accidents, fire or natural disasters
                <br>
                3- maximum compensation for the loss of any consignment, the value of the consignment belonging to a carrier, or a maximum of (100) one hundred riyals, unless otherwise agreed
                <br>
                4- transport is not responsible for the content of any consignment
                <br>
                5- the carrier is not responsible for any consignment that has not been received by the addresse and has not been received by the sender after the lapse of twenty one (21) days
                <br>
                6- receiving and signing the policy copy as acceptance of all the transport conditions
                <br>
                7- the right to suspend any consignment that carrier finds to be in violation of the conditions of carriage
                <br>
                8- the agreed periodof transport is five days, and the sender has no right to complain before that period
            </div>
        </div>
        <div class="d-flex justify-content-between mt-3 mb-3">
            <div class="box-signature">التوقيع على الشروط signature</div>
            <div class="box-signature">التوقيع على الشروط signature</div>
        </div>
        <div class="d-flex justify-content-between">
            <p>www.ntexpress.sa</p>
            <p>info@ntexpress.sa</p>
            <p>920019908/0112700300</p>
            <p>jansid ibrahim</p>
        </div>
    </div>
</div>

<script src="{{ asset('assets/invoice') }}/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/invoice') }}/js/all.min.js"></script>

</body>
</html>
