<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('notifications.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="">اختر</label>
                    <select name="choose" id="choose" class="form-control">
                        <option value="all">الكل</option>
                        <option value="all_driver">كل السائقين</option>
                        <option value="all_user">كل المستخدمين</option>
                        <option value="user">مستخدم</option>
                        <option value="driver">سائق</option>
                    </select>
                </div>
                <div class="col-6" id="user-select">
                    <label for="">المستخدمين</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="">العنوان</label>
                    <input type="text" class="form-control" name="title">
                </div>
                <div class="col-12">
                    <label for="">الوصف</label>
                    <textarea name="description" rows="8" class="form-control"></textarea>
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

    $(document).on('change', '#choose', function() {
        if ($(this).val() === 'user' || $(this).val() === 'driver') {
            $('#user-select').show();
        } else {
            $('#user-select').hide();
        }
    });
</script>
