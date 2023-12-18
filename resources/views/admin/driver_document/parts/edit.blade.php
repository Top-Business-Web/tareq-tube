<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="">
        @csrf
        @method('PUT')
        <input type="hidden" value="" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="name" class="form-control-label">الصورة</label>
                    <input type="file" class="dropify" name="image"
                        data-default-file="{{ asset($driver_document->agency_number) }}" value=""
                        accept="image/png,image/webp,image/gif,image/jpeg,image/jpg" disabled />
                </div>
                <div class="col-6">
                    <label for="name" class="form-control-label">الصورة</label>
                    <input type="file" class="dropify" name="image"
                        data-default-file="{{ asset($driver_document->bike_license) }}" value=""
                        accept="image/png,image/webp,image/gif,image/jpeg,image/jpg" disabled />
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label for="name" class="form-control-label">الصورة</label>
                    <input type="file" class="dropify" name="image"
                        data-default-file="{{ asset($driver_document->agency_number) }}" value=""
                        accept="image/png,image/webp,image/gif,image/jpeg,image/jpg" disabled />
                </div>
                <div class="col-4">
                    <label for="name" class="form-control-label">الصورة</label>
                    <input type="file" class="dropify" name="image"
                        data-default-file="{{ asset($driver_document->agency_number) }}" value=""
                        accept="image/png,image/webp,image/gif,image/jpeg,image/jpg" disabled />
                </div>
                <div class="col-4">
                    <label for="name" class="form-control-label">الصورة</label>
                    <input type="file" class="dropify" name="image"
                        data-default-file="{{ asset($driver_document->agency_number) }}" value=""
                        accept="image/png,image/webp,image/gif,image/jpeg,image/jpg" disabled />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
