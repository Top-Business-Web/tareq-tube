<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{ route('slider.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-12">
                    <label for="name" class="form-control-label">الصورة*</label>
                    <input type="file" class="dropify" name="image"
                        data-default-file="{{ asset('assets/uploads/slider.png') }}"
                        accept="image/png,image/webp , image/gif, image/jpeg,image/jpg" />
                    <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif, jpeg,
                        jpg,webp</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="name" class="form-control-label">الرابط*</label>
                    <input type="text" name="link" class="form-control">
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
    $(document).ready(function() {
        $('select').select2();
    });
</script>
