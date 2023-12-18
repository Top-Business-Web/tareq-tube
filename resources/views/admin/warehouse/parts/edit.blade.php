<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('warehouse.update',$warehouse->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{$warehouse->id}}" name="id">
        <div class="form-group">
            <div class="row">

                <div class="col-12">
                    <label for="city_id" class="form-control-label">المدينة</label>
                    <select class="form-control" name="city_id" id="city_id" required>
                        <option value="" selected>اختر المدينة</option>
                        @foreach($cities as $city)
                            <option
                                {{ $city->id == $warehouse->city_id ? 'selected' : '' }}
                                value="{{ $city->id }}">{{ $city->name_ar }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="name_ar" class="form-control-label">الاسم بالعربية</label>
                    <input type="text" class="form-control" value="{{ $warehouse->name_ar }}" name="name_ar" id="name_ar"
                           placeholder="مثال :مخزن الرياض" required>
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" class="form-control" value="{{ $warehouse->name_en }}" name="name_en" id="name_en"
                           placeholder="مثال : Riyadh warehouse" required>
                </div>

                <div class="col-12">
                    <label for="lan" class="form-control-label">(long) خط الطول</label>
                    <input type="text" class="form-control" value="{{ $warehouse->lan }}" name="lan" id="lan" placeholder="مثال : 46.675297" required>
                    <label for="lat" class="form-control-label">(lat) خط العرض</label>
                    <input type="text" class="form-control" value="{{ $warehouse->lat }}" name="lat" id="lat" placeholder="مثال : 24.713552" required>
                </div>

                <div class="col-12">
                    <label for="details_ar" class="form-control-label">التفاصيل بالعربية</label>
                    <textarea class="form-control" name="details_ar" id="details_ar" rows="5" required>{{ $warehouse->details_ar }}</textarea>
                    <label for="details_en" class="form-control-label">التفاصيل بالانجليزية</label>
                    <textarea class="form-control" name="details_en" id="details_en" rows="5" required>{{ $warehouse->details_en }}</textarea>
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
