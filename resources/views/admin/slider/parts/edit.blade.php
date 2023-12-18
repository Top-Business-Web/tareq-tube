<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{ route('slider.update', $slider->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $slider->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-12">
                    <label for="name" class="form-control-label">الصورة*</label>
                    <input type="file" class="dropify" name="image" data-default-file="{{ asset($slider->image) }}"
                        accept="image/png,image/webp , image/gif, image/jpeg,image/jpg" />
                    <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif, jpeg,
                        jpg,webp</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="name" class="form-control-label">الرابط*</label>
                    <input type="text" name="link" value="{{ $slider->link }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
