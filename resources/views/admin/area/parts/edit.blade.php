<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('area.update',$area->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{$area->id}}" name="id">

        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="name_ar" class="form-control-label">اسم المنطقة</label>
                    <input type="text" class="form-control" name="name" value="{{ $area->name }}" id="name" placeholder="مثال : عمر ايبلي"
                        required>
                </div>
                <div class="col-6">
                    <label for="name_ar" class="form-control-label">المدن</label>
                    <select name="city_id" id="" class="form-control">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ $city->id == $area->city_id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
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
