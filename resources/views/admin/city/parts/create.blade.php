<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('city.store')}}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-12">
                    <label for="name_ar" class="form-control-label">الاسم</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="مثال : بغداد" required>
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

