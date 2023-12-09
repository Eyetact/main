@extends('layouts.master')
@section('css')
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- Slect2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />

    <link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/wysiwyag/richtext.css"
        rel="stylesheet" />
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}    ">
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">add Plans</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Plans</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('plans.index') }}">add</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <div class="btn btn-list">
                {{--                <a href="{{ route('smtp.create') }}" class="btn btn-info" title="" data-original-title="Add new"><i class="fe fe-plus mr-1"></i> Add Swift Mailer </a> --}}
            </div>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    @push('styles')
        <!-- INTERNAL Sumoselect css-->
        <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}    ">

        <!-- INTERNAL File Uploads css -->
        <link href="{{ asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

        <!-- INTERNAL File Uploads css-->
        <link href="{{ asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">add Plan</h3>
        </div>
        <div class="card-body pb-2">
            <form action="{{ route('plans.store') }}" method="POST" id="mailboxForm" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-lg-12 col-sm-12">
                        <div class="input-box">
                            <label for="name" class="input-label">Name</label>
                            <input type="text" class="google-input" name="name" id="name" value="" />
                        </div>
                        @error('name')
                            <label id="name-error" class="error" for="name">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-lg-12 col-sm-12">
                        <label class="form-label">image</label>
                        <input type="file" class="dropify" name="image" data-default-file="" data-height="180" />
                    </div>




                    {{-- <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="details" class="input-label">details</label>
                            <input type="text" class="google-input" name="details" id="details" value="" />
                        </div>
                        @error('details')
                            <label id="details-error" class="error" for="details">{{ $message }}</label>
                        @enderror
                    </div> --}}


                    <div class="col-lg-12 col-sm-12">
                        <div class="input-box">
                            <label class="form-label">details<span class="text-danger"></span></label>
                            <textarea class="content" name="details" id="details" value="">

                                    </textarea>
                        </div>


                        @error('details')
                            <label id="details-error" class="error" for="details">{{ $message }}</label>
                        @enderror
                    </div>


                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="period" class="input-label">period</label>
                            <input type="number" class="google-input" name="period" id="period" value="" />
                        </div>
                        @error('period')
                            <label id="period-error" class="error" for="period">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="input-box">
                            <label for="price" class="input-label">price</label>
                            <input type="text" class="google-input" name="price" id="price" value="" />
                        </div>
                        @error('price')
                            <label id="price-error" class="error" for="price">{{ $message }}</label>
                        @enderror
                    </div>
                    

                    <div class="col-sm-6 col-md-6">

                        <div class="input-box">
                            {{-- <label for="permission_type">Permission Type:</label> --}}
                            <select class="google-input" id="permission_type" name="type">
                                <option selected disabled>Select Permission Type</option>
                                <option value="user">User</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group ">
                            <label class="form-label">Permissions</label>
                            <div class="selectgroup selectgroup-pills">
                                {{-- @foreach ($permissions as $p)
                                <label class="selectgroup-item">
                                    <input type="checkbox" name="permissions[]" value="{{ $p->id }}" class="selectgroup-input"
                                        >
                                    <span class="selectgroup-button">{{$p->name}}</span>
                                </label>
                                @endforeach --}}

                                <div id="permissions"></div>

                            </div>
                        </div>
                    </div>



                    <div class="col-sm-6 col-md-6">

                        <div class="input-box">
                            {{-- <label for="permissions">Permissions:</label> --}}
                            {{-- <select class="google-input" name="permissions[]" multiple id="permissions">
                                <!-- Permissions for the selected type will be dynamically loaded here -->
                            </select> --}}
                        </div>
                    </div>

                </div>



                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="{{ route('plans.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <!--INTERNAL Sumoselect js-->
    <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script src="{{ asset('assets/js/formelementadvnced.js') }}"></script>

    <!-- INTERNAL File-Uploads Js-->
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

    <!-- INTERNAL File uploads js -->
    <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ asset('assets/js/filupload.js') }}"></script>

    <!--INTERNAL Sumoselect js-->
    <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{ asset('assets/js/formelementadvnced.js') }}"></script>
    <script src="{{ asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ asset('assets/js/file-upload.js') }}"></script>
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/wysiwyag/jquery.richtext.js">
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script type="text/javascript">
        // $(document).ready(function() {
        $("#mailboxForm").validate({
            onkeyup: function(el, e) {
                $(el).valid();
            },
            // errorClass: "invalid-feedback is-invalid",
            // validClass: 'valid-feedback is-valid',
            ignore: ":hidden",
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                password: {
                    required: true,
                }

            },
            messages: {},
            errorPlacement: function(error, element) {
                error.insertAfter($(element).parent());
            },
        });

        $("input[type='text'], input[type='number'], input[type='password'], input[type='email'], input[type='tel']").on(
            "keyup",
            function() {
                var $input = $(this);
                if ($input.val() != '') {
                    $input.parents(".input-box").addClass("focus");
                } else {
                    $input.parents(".input-box").removeClass("focus");
                }
            });
        $("input[type='text'], input[type='number'], input[type='password'], input[type='email'], input[type='tel']").each(
            function(index, element) {
                var value = $(element).val();
                if (value != '') {
                    $(this).parents('.input-box').addClass('focus');
                } else {
                    $(this).parents('.input-box').removeClass('focus');
                }
            });
        // });

        $(function(e) {
            $('.content').richText();
            $('.content2').richText();
        });


        $(document).ready(function() {
            $('#permission_type option[value=user]').attr('selected','selected');
            getPermissionsByType($('#permission_type').val());
            $('#permission_type').change(function() {
                var selectedType = $(this).val();
                getPermissionsByType(selectedType);
            });

            function getPermissionsByType(type) {
                var permissionsSelect = $('#permissions');
                permissionsSelect.empty();

                if (type === 'user') {
                    @foreach ($user_permissions as $permission)
                        var span =
                            ' <label class="selectgroup-item"><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="selectgroup-input"><span class="selectgroup-button">{{ $permission->name }}</span></label>';
                        permissionsSelect.append(span);
                    @endforeach
                } else if (type === 'customer') {
                    @foreach ($customer_permissions as $permission)
                        var span =
                            ' <label class="selectgroup-item"><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="selectgroup-input"><span class="selectgroup-button">{{ $permission->name }}</span></label>';

                        permissionsSelect.append(span);
                    @endforeach
                }
            }
        });
    </script>
@endpush
