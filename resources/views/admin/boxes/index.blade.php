@extends('admin/layouts/master')

@section('title')
    {{($setting->name_en) ?? ''}} | الصناديق اليومية
@endsection
@section('page_name')
    الصناديق اليومية
@endsection
@section('content')
    <style>
        .tgl {
            display: none;
        }

        .tgl, .tgl:after, .tgl:before, .tgl *, .tgl *:after, .tgl *:before, .tgl + .tgl-btn {
            box-sizing: border-box;
        }

        .tgl::-moz-selection, .tgl:after::-moz-selection, .tgl:before::-moz-selection, .tgl *::-moz-selection, .tgl *:after::-moz-selection, .tgl *:before::-moz-selection, .tgl + .tgl-btn::-moz-selection {
            background: none;
        }

        .tgl::selection, .tgl:after::selection, .tgl:before::selection, .tgl *::selection, .tgl *:after::selection, .tgl *:before::selection, .tgl + .tgl-btn::selection {
            background: none;
        }

        .tgl + .tgl-btn {
            outline: 0;
            display: block;
            width: 4em;
            height: 2em;
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .tgl + .tgl-btn:after, .tgl + .tgl-btn:before {
            position: relative;
            display: block;
            content: "";
            width: 50%;
            height: 100%;
        }

        .tgl + .tgl-btn:after {
            left: 0;
        }

        .tgl + .tgl-btn:before {
            display: none;
        }

        .tgl:checked + .tgl-btn:after {
            right: 50%;
        }

        .tgl-light + .tgl-btn {
            background: #f0f0f0;
            border-radius: 2em;
            padding: 2px;
            transition: all 0.4s ease;
        }

        .tgl-light + .tgl-btn:after {
            border-radius: 50%;
            background: #fff;
            transition: all 0.2s ease;
        }

        .tgl-light:checked + .tgl-btn {
            background: #9FD6AE;
        }

        .tgl-ios + .tgl-btn {
            background: #fbfbfb;
            border-radius: 2em;
            padding: 2px;
            transition: all 0.4s ease;
            border: 1px solid #e8eae9;
        }

        .tgl-ios + .tgl-btn:after {
            border-radius: 2em;
            background: #fbfbfb;
            transition: left 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), padding 0.3s ease, margin 0.3s ease;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1), 0 4px 0 rgba(0, 0, 0, 0.08);
        }

        .tgl-ios + .tgl-btn:hover:after {
            will-change: padding;
        }

        .tgl-ios + .tgl-btn:active {
            box-shadow: inset 0 0 0 2em #e8eae9;
        }

        .tgl-ios + .tgl-btn:active:after {
            padding-right: 0.8em;
        }

        .tgl-ios:checked + .tgl-btn {
            background: #86d993;
        }

        .tgl-ios:checked + .tgl-btn:active {
            box-shadow: none;
        }

        .tgl-ios:checked + .tgl-btn:active:after {
            margin-left: -0.8em;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> الصناديق اليومية {{($setting->name_en) ?? ''}}</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        @foreach($boxes as $box)
                            @php
                                if ($box->day == 1)
                                    $box->day = 'الاول';
                                elseif($box->day == 2)
                                    $box->day = 'الثاني';
                                elseif($box->day == 3)
                                    $box->day = 'الثالث';
                                elseif($box->day == 4)
                                    $box->day = 'الرابع';
                                elseif($box->day == 5)
                                    $box->day = 'الخامس';
                                elseif($box->day == 6)
                                    $box->day = 'السادس';
                                elseif($box->day == 7)
                                    $box->day = 'السابع';
                            @endphp
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{ route('box.update',$box->id) }}">
                                @csrf
                                <input type="hidden" value="{{ $box->id }}" name="id">
                                <div class="row">
                                    <div class="col-md-2">
                                        <h4 for="day" class="form-control-label" style="margin-top: 2.0rem !important;"> اليوم  {{ $box->day }}</h4>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="prize" class="form-control-label">المكافئة</label>
                                        <input class="form-control" type="number" name="prize"
                                               value="{{ $box->prize }}">
                                    </div>
                                    <div class="col-md-3"
                                         style="display: flex; align-items: center;">
                                        <label class="form-control-label ml-5 mt-5">مميز</label>
                                        <input class="tgl tgl-ios" dir="rtl" style="margin-top:1.75rem !important;"
                                               id="cb2-box{{$box->id}}" name="gold" type="checkbox"
                                               {{ $box->gold == '1' ? 'checked' : '' }}
                                               value="1"/>
                                        <label class="tgl-btn" dir="rtl" style="margin-top:1.75rem !important;"
                                               for="cb2-box{{$box->id}}"></label>
                                    </div>
                                    <div class="col-md-3">
                                        <button style="margin-top:1.75rem !important;" type="submit" class="btn btn-pill btn-primary-gradient">تحديث الصندوق</button>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin/layouts/myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'day', name: 'day'},
            {data: 'prize', name: 'prize'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('box.index')}}', columns);

        {{--deleteScript('{{route('city.delete', ':id')}}');--}}
    </script>
@endsection


