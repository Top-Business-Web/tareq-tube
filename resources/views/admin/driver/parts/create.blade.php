<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('driver.store')}}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-4">
                    <label for="name" class="form-control-label">الصورة</label>
                    <input type="file" class="dropify" name="image"
                           data-default-file="{{asset('assets/uploads/avatar.png')}}"
                           value="{{asset('assets/uploads/avatar.png')}}"
                           accept="image/png,image/webp , image/gif, image/jpeg,image/jpg"/>
                    <span
                        class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif, jpeg, jpg,webp</span>
                </div>
                <div class="col-8">
                    <label for="name" class="form-control-label">الاسم</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="example : ahmed saad" required>
                    <label for="email" class="form-control-label">الايميل</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="example : ahmed@email.com" required>
                    <label for="password" class="form-control-label">كلمة المرور</label>
                    <input type="password" class="form-control" name="password" placeholder="**********" id="password" required>
                </div>
            </div>

            <hr class="custom-border">

            <div class="row">
                <div class="col-6">
                    <label for="national_id" class="form-control-label">رقم الهوية</label>
                    <input type="text" class="form-control" name="national_id" placeholder="example : 12345678987654" id="national_id" required>
                </div>
                <div class="col-6">
                    <label for="phone" class="form-control-label">الهاتف</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="example : +965342343" required>
                </div>
                <div class="col-6">
                    <label for="city_id" class="form-control-label">المدينة</label>
                    <select class="form-control" name="city_id" id="city_id" required>
                        <option value="" selected>اختر المدينة</option>
                    @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="type" class="form-control-label">نوع الانشاء</label>
                    <h1 class="d-flex btn btn-success">سائق</h1>
                    <input type="hidden" value="driver" class="form-control" name="type" id="type">
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('select').select2();
    });
</script>

