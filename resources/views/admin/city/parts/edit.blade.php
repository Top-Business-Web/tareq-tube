<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('city.update',$city->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{$city->id}}" name="id">

        <div class="form-group">
            <div class="row">
                <div class="col-12">
                    <label for="name" class="form-control-label">الاسم</label>
                    <input type="text" class="form-control" value="{{ $city->name }}" name="name" id="name"
                           placeholder="مثال : الرياض" required>
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
