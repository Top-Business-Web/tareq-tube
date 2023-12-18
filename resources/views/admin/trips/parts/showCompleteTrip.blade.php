<div class="modal-body">

    <div class="form-group">
        <div class="row">
            <div class="col-12">
                <h4 class="d-flex font-weight-bold justify-content-center">معلومات الرحلة</h4>
                <table class="table table-bordered">
                    <tr class="badge-success">
                        <td>من</td>
                        <td>خط العرض</td>
                        <td>خط الطول</td>
                        <td>الي</td>
                        <td>خط العرض</td>
                        <td>خط الطول</td>
                        <td>تاريخ الركوب</td>
                        <td>تاريخ الوصول</td>
                        <td>المسافة</td>
                        <td>الوقت</td>
                    </tr>
                    <tr>
                        <td>{{ $trip->from_address }}</td>
                        <td>{{ $trip->from_long }}</td>
                        <td>{{ $trip->from_lat }}</td>
                        <td>{{ $trip->to_address }}</td>
                        <td>{{ $trip->from_long }}</td>
                        <td>{{ $trip->from_lat }}</td>
                        <td>{{ $trip->time_ride }}</td>
                        <td>{{ $trip->time_arrive }}</td>
                        <td>{{ $trip->distance }} KM</td>
                        <td>{{ $trip->time }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 ">
                <h4 class="d-flex font-weight-bold justify-content-center">بيانات العميل</h4>
                <table class="table table-bordered">
                    <tr class="badge-success">
                        <td>اسم العميل</td>
                        <td>هاتف العميل</td>
                        <td>البريد الالكتروني</td>
                    </tr>
                    <tr>
                        <td>{{ $trip->user->name }}</td>
                        <td>{{ $trip->user->phone }}</td>
                        <td>{{ $trip->user->email }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-12 ">
                <h4 class="d-flex font-weight-bold justify-content-center">بيانات السائق</h4>
                <table class="table table-bordered">
                    <tr class="badge-success">
                        <td>اسم السائق</td>
                        <td>هاتف السائق</td>
                        <td>البريد الالكتروني</td>
                    </tr>
                    <tr>
                        <td>
                            {{ $trip->driver->name }}</td>
                        <td>{{ $trip->driver->phone }}</td>
                        <td>{{ $trip->driver->email }}</td>
                    </tr>
                </table>
            </div>

            @php
                $settigs = App\Models\Setting::first(['vat', 'km']);
                $price = $trip->distance * $settigs->km; // Calculate the total price based on the distance
                $vatTotal = $price * ($settigs->vat / 100); // Calculate 15% of the total price as VAT
                $total = $price - $vatTotal; // Calculate the total after deducting the VAT
            @endphp
            <div class="col-12 ">
                <h4 class="d-flex font-weight-bold justify-content-center">بيانات المحفظة</h4>
                <table class="table table-bordered">
                    <tr class="badge-success">
                        <td>السعر الاساسي</td>
                        <td>الخصم</td>
                        <td>الصافي</td>
                    </tr>
                    <tr>
                        <td>{{ $price }}</td>
                        <td>{{ $vatTotal }}</td>
                        <td>{{ $total }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
    </div>
</div>

<script>
    $('.dropify').dropify();

    $(document).ready(function() {
        $("#printBtn").on('click', function() {

            $.get('', function(data) {
                // Create a hidden iframe and set its content to the Blade view
                var iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
                iframe.contentWindow.document.open();
                iframe.contentWindow.document.write(data);
                iframe.contentWindow.document.close();


                // Print the iframe's content
                setTimeout(function() {
                    iframe.contentWindow.print();
                }, 1000);

                // Remove the iframe from the DOM after printing
                setTimeout(function() {
                    document.body.removeChild(iframe);
                }, 2000); // Adjust the delay as needed
            })

        });
    });
</script>
