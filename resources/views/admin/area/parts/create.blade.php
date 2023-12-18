<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('area.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="name_ar" class="form-control-label">اسم المنطقة</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="مثال : بغداد"
                        required>
                </div>
                <div class="col-6">
                    <label for="name_ar" class="form-control-label">المدن</label>
                    <select name="city_id" id="" class="form-control">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
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
</script>
